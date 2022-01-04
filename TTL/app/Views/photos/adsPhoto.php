<h2><?= esc($title) ?></h2>
<!-- TODO debug à virer -->
photo/adsPhoto.php<br/>
<div>
    <?php if (!empty($photo) && is_array($photo)) : ?>

        <?php foreach ($photo as $photo_item) : ?>
            <p><a title="Voir la photo" href="/photos/<?= esc($photo_item['P_idphoto'], 'url') ?>">
                    <?php echo ' <img src = "data:image/png;base64,' . base64_encode($photo_item['P_data']) . '" width = "300px" height = "300px"/>' ?> </a></p>

        <?php endforeach; ?>

    <?php else : ?>

        <h3>Pas de photos</h3>

        <p>Impossible d'afficher les photos, ou aucune photo</p>

    <?php endif ?>
</div>