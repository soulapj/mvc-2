<?php require APPROOT . '/views/bases/header.php'; ?>
<?php
// dd($data);
$likes = 0;
foreach ($data['likes'] as $like) {
  if ($like->id_post == $data['post']->id) {
    $likes++;
  }
}

?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Retour</a>
<br>
<h1><?php echo htmlspecialchars_decode($data['post']->title); ?></h1>
<div class="container bg-secondary text-white d-flex p-2 flex-row justify-content-between">
  <span>Publié par le <?php echo $data['post']->dateCreated; ?></span>
  <span class="" style="color: #ff8f93; font-weight: bold;">
    <a href="<?php echo URLROOT; ?>/likes/addLike/<?= $data['post']->id ?>" style="color: #ff8f93;"><i
        class="bi bi-heart-fill"></i></a>
    <?= $likes > 0 ? $likes : '' ?></span>
  <?php ?>
  </span>
</div>
<?php $allowed_tags = '<p><b><i><strong><em><span><ul><ol><li><br><hr><img><h1><h2><h3><h4><h5><h6>'; ?>
<p class="card-text"><?= strip_tags(htmlspecialchars_decode($data['post']->content), allowed_tags: $allowed_tags) ?>
</p>
<?php if ($data['post']->id_user == $_SESSION['user_id']) { ?>
  <hr>
  <div class="d-flex justify-content-between">
    <a href="<?php echo URLROOT; ?>/posts/update/<?= $data['post']->id ?> " class="btn btn-dark">Modifier</a>
    <a href="<?php echo URLROOT; ?>/posts/delete/<?= $data['post']->id ?> " class="btn btn-danger"
      onclick="return confirm('Voulez-vous supprimer ce post ?');">Supprimer</a>
  </div>
<?php } ?>


<div class="comment-section">
  <?php $nbComments = count($data['comments']) ?>
  <h2>Commentaire<?= $nbComments > 1 ? 's' . ' (' . $nbComments . ')' : '' ?></h2>
  <?php foreach ($data['comments'] as $comment) { ?>
    <div class="comment">
      <div class="comment-header">
        <i class="fas fa-user-circle comment-icon"></i>
        <div class="comment-user">
          <?php $date = new DateTime($comment->date) ?>
          <div class="comment-author">Publié par : <?= htmlspecialchars_decode($comment->nom) ?> le
            <?= date_format($date, 'd/m/Y à H:i:s') ?>
          </div>
        </div>
      </div>
      <div class="comment-body">
        <p id="commentContent-<?= $comment->id ?>"><?= htmlspecialchars_decode($comment->comment) ?></p>
      </div>
      <?php if ($comment->id_user == $_SESSION['user_id']) { ?>
        <a href="" class="modifyComment btn btn-primary" id="modifyButton-<?= $comment->id ?>">Modifier</a>
        <a href="<?php echo URLROOT; ?>/comments/delete/<?= $data['post']->id ?>/<?= $comment->id ?>" class="btn btn-danger"
          onclick="return confirm('Voulez-vous supprimer ce post ?');">Supprimer</a>
      <?php } ?>
    </div>
  <?php } ?>
</div>


<!-- Formulaire pour ajouter un commentaire -->
<h3 id="title">Ajouter un commentaire</h3>
<?php if (!empty($_SESSION['flashComment'])) {
  flash('flashComment');
} ?>
<form id="form" action="<?= URLROOT ?>/comments/add/<?= $data['post']->id ?> " method="POST">
  <div class="form-group">
    <input type="hidden" name="postId" value="<?= $data['post']->id ?>"></input>
    <textarea id="text" name="body" class="form-control"></textarea>
    <?php if (!empty($_SESSION['flashCommentFail'])) {
      flash('flashCommentFail');
    } ?>
  </div>
  <button id="valid" type="submit" class="btn btn-primary">Commenter</button>
  <button id="cancel" type="button" class="btn btn-danger d-none">Annuler</button>
</form>


<!-- logique pour intégrer la modification d'un commentaire dans le form d'ajout de commentaire  -->
<script>
  //  récupérer les éléments 
  let modifyButton = document.querySelectorAll('.modifyComment');
  let form = document.querySelector('#form');
  let textarea = document.querySelector('#text');
  let title = document.querySelector("#title");
  let vButton = document.querySelector("#valid");
  let cButton = document.querySelector("#cancel");

  // Mettre un event sur chaque btn de modification de commentaire 
  modifyButton.forEach(button => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      // récupérer l'id du commentaire 
      let commentId = button.id.split('-')[1];
      // Récupérer la valeur du commentaire
      let content = document.querySelector(`#commentContent-${commentId}`).innerHTML;
      // Modifier l'attr action du form
      form.action = "<?= URLROOT ?>/comments/update/" + commentId;
      // Mettre la valeur du commentaire dans le textarea
      textarea.value = content;
      // Modifier le titre du form
      title.innerHTML = "Modifier mon commentaire";
      // Modifier le texte du bouton de validation
      vButton.textContent = "Modifier";
      // Afficher le bouton d'annulation
      cButton.classList.remove('d-none');
      // Faire défiler la page pour voir le form
      form.scrollIntoView({
        behavior: 'smooth'
      });
    })
  })
  // Mettre un event sur le bouton d'annulation
  cButton.addEventListener('click', (e) => {
    // Modifier l'attr action du form pour le remettre à l'ajout de commentaire
    form.action = "<?= URLROOT ?>/comments/add/<?= $data['post']->id ?>";
    // Vider le textarea
    textarea.value = "";
    // Modifier le titre du form
    title.innerHTML = "Ajouter un commentaire";
    // Modifier le texte du bouton de validation
    vButton.textContent = "Ajouter";
    // Enlever le bouton d'annulation
    cButton.classList.add('d-none');
  })
</script>

<?php require APPROOT . '/views/bases/footer.php'; ?>