<?php require APPROOT . '/views/bases/header.php'; ?>
<div class="row mb-3">
  <div class="col-md-6">
    <h1>Posts</h1>
  </div>
  <?php if (!empty($_SESSION['flashAdd'])) {
    flash('flashAdd');
  } ?>
  <?php if (!empty($_SESSION['flashFailure'])) {
    flash('flashFailure');
  } ?>
  <div class="col-md-6">
    <a href="<?php echo URLROOT; ?>/posts/addPost" class="btn btn-primary pull-right">
      <i class="fa fa-pencil"></i> Ajouter un post
    </a>
  </div>
</div>
<?php foreach ($data['posts'] as $post): ?>
  <?php
  $likes = 0;
  foreach ($data['likes'] as $like) {
    if ($like->id_post == $post->postId) {
      $likes++;
    }
  }
  ?>
  <div class="card card-body mb-3">
    <!-- ici on affiche avec la syntaxe des objets en PHP car dans la requete on spécifie PDO::FETCH_OBJ -->
    <h4 class="card-title"><?= htmlspecialchars_decode($post->title) ?></h4>
    <div class="bg-light mb-3">
      <div class="container d-flex p-2 flex-row justify-content-between">
        <span>Publié par <?= htmlspecialchars($post->nom) ?> le <?= $post->dateCreated; ?></span>
        <span><span class="container" style="color: #ff8f93; font-weight: bold;"><i class="bi bi-heart-fill"
              style="font-weight: bold;"></i>
            <?= $likes > 0 ? $likes : '' ?></span>
          <?php ?>
        </span>
      </div>
    </div>
    <?php $allowed_tags = '<p><b><i><strong><em><span><ul><ol><li><br><hr><img><h1><h2><h3><h4><h5><h6>'; ?>
    <p class="card-text">
      <?php if (strlen(string: $post->content) > 800) { ?>
      <p><?= substr(strip_tags(htmlspecialchars_decode($post->content), $allowed_tags), 0, 800) ?>...</p>
    <?php } else { ?>
      <p><?= strip_tags(htmlspecialchars_decode($post->content), $allowed_tags) ?></p>
    <?php } ?>
    </p>

    <!-- redirection à faire sur la structure du router : controlerName/methodName/params -->
    <a href="<?php echo URLROOT; ?>/posts/details/<?php echo $post->postId; ?>" class="btn btn-dark">Voir plus</a>
  </div>
<?php endforeach; ?>
<?php require APPROOT . '/views/bases/footer.php'; ?>