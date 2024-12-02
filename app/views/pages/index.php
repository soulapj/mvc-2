<?php require APPROOT . '/views/bases/header.php'; ?>
<div class="container">
    <h1 class="text-center mt-3"><?= $data['title'] ?></h1>
    <p class="mt-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto ut officia facilis, commodi sunt eius
        ad vero adipisci hic ipsa assumenda odio obcaecati soluta quae possimus suscipit dicta magnam repudiandae,
        molestiae fuga aliquid? Culpa, ea dolore velit optio minima aut temporibus ducimus omnis a, amet sequi inventore
        quod odit deleniti cumque quam. Inventore accusamus dolorum eaque labore, neque laudantium consequatur provident
        consequuntur debitis harum officiis ex possimus voluptas mollitia ipsam accusantium eius veritatis quo autem
        voluptatem unde voluptatibus distinctio. Reprehenderit ratione veritatis recusandae. Aut magnam qui molestiae
        voluptatum vero soluta dolorum, nobis saepe ullam, aliquid laudantium aperiam assumenda! Nam, assumenda?</p>
</div>
<?php if (isLoggedIn()) { ?>
    <div class="container d-flex gap-5">
        <div class="container border border-3 border-success mt-3 p-3 rounded w-50 d-flex flex-column">
            <h3 class="border-bottom border-2 border-success text-success mb-3">Les derniers posts</h3>
            <?php foreach ($data['last'] as $key => $value) { ?>
                <div class="mb-3">
                    <a class='text-success' style="text-decoration: none;"
                        href="<?php echo URLROOT; ?>/posts/details/<?php echo $value->postId; ?>">
                        <span><?= strlen($value->title) > 35 ? substr($value->title, 0, 35) . '...' : $value->title ?></span><span>
                            - publié le <?= $value->dateCreated ?></span><span> par
                            <?= $value->nom ?></span>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="container border border-3 border-success mt-3 p-3 rounded w-50 d-flex flex-column">
            <h3 class="border-bottom border-2 border-success text-success mb-3">Les meilleurs posts</h3>
            <?php foreach ($data['best'] as $key => $value) { ?>
                <div class="mb-3 d-flex align-items-center w-100 d-flex justify-content-between">
                    <a class='text-success' style="text-decoration: none;"
                        href="<?php echo URLROOT; ?>/posts/details/<?php echo $value->id_post; ?>">
                        <span>
                            <?= strlen($value->title) > 30 ? substr($value->title, 0, 30) . '...' : $value->title ?> - publié le
                            <?= $value->dateCreated ?> par <?= $value->nom ?>
                        </span>
                    </a>
                    <span>
                        <span class="container" style="color: #ff8f93; font-weight: bold;"><i class="bi bi-heart-fill"
                                style="font-weight: bold;"></i>
                            <?= $value->likes ?>
                        </span>
                    </span>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php require APPROOT . '/views/bases/footer.php'; ?>