<?php require APPROOT . '/views/bases/header.php'; ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Retour</a>
<?php if (!empty($_SESSION['flashFailure'])) {
    flash('flashFailure');
} ?>

<div class="card card-body bg-light mt-5">
    <h2>Publier un post </h2>
    <p>Remplissez ce formulaire pour publier un post</p>
    <form action="<?php echo URLROOT; ?>/posts/addPost" method="post">
        <div class="form-group">
            <label for="title">Titre: <sup>*</sup></label>
            <input type="text" name="title" class="form-control form-control-lg">
            <?php if (!empty($_SESSION['flashTitle'])) {
                flash('flashTitle');
            } ?>
        </div>
        <div class="form-group">
            <div style="display: none;" id="content">
                <p>Ceci <strong>est</strong> un <em>exemple</em> de <span
                        style="text-decoration: underline;">contenu</span>!</p>
            </div>
            <label for="body">Contenu: <sup>*</sup></label>
            <textarea name="body" id="body" class="form-control form-control-lg"></textarea>
            <?php if (!empty($_SESSION['flashBody'])) {
                flash('flashBody');
            } ?>
        </div>
        <input type="submit" class="btn btn-success" value="Publier">
    </form>
</div>

<?php require APPROOT . '/views/bases/footer.php'; ?>