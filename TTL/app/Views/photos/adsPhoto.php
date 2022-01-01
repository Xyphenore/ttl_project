<h2><?= esc($title) ?></h2>
<div>
    <?php if (!empty($photo) && is_array($photo)) : ?>

        <?php foreach ($photo as $photo_item) : ?>
            <p><a title="Voir la photo" href="/photos/<?= esc($photo_item['P_idphoto'], 'url') ?>"> <?= esc($photo_item['P_titre']) ?> </a>
            </p>

        <?php endforeach; ?>

    <?php else : ?>

        <h3>Pas de photos</h3>

        <p>Impossible d'afficher les photos, ou aucune photo</p>

    <?php endif ?>
</div>