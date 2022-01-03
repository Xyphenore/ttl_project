<!-- Affichage de toutes les annonces publiées ou non sur le site
n'est visible que par l'utilisateur les ayant créées -->

<h2><?= esc($tete) ?></h2>
<div style="border: thin solid black">
    <?php if (!empty($messages) && is_array($messages)) : ?>
        <?php foreach ($messages as $key => $value) : ?>
            <?php foreach ($value as $k => $v) : ?>

                <!-- Div d'un message -->
                <div style="border: thin solid blue">
                id annonce : <?= esc($v['A_idannonce']) ?>
                de : <?= esc($v['U_mail']) ?> - le : <?= esc($v['M_dateheure_message']) ?>
                    <a title="Détail" href="/message/<?= esc($v['M_idmessage'], 'url') ?>">
                        message : </a><br />
                    <div>
                        <?= esc($v['M_texte_message']) ?>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php else : ?>
        <h3>Aucune annonce publiée</h3>
    <?php endif ?>
</div>