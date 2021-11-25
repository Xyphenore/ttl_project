<h2><?= esc($title) ?></h2>

<?php if (! empty($ads) && is_array($ads)): ?>

    <?php foreach ($ads as $ads_item): ?>

        <h3><?= esc($ads_item['title']) ?></h3>

        <div class="main">
            <?= esc($ads_item['body']) ?>
        </div>
        <p><a href="/ads/<?= esc($ads_item['slug'], 'url') ?>">View article</a></p>

    <?php endforeach; ?>

<?php else: ?>

    <h3>No ads</h3>

    <p>Unable to find any ads for you.</p>

<?php endif ?>