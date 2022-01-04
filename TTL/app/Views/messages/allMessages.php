<!-- Affichage de toutes les annonces publiées ou non sur le site
n'est visible que par l'utilisateur les ayant créées -->

<h2><?= esc($tete) ?></h2>
<div style="border: thin solid black">
    <?php if (!empty($messages) && is_array($messages)) : ?>
        <?php foreach ($messages as $k => $v) : ?>

            <!-- Div d'un message -->
            <!-- l'indice 0 contient le pseudo -->
            <div style="border: thin solid blue">

                de : <a title="Détail" href="/users/<?= esc($v[0], 'url') ?>">
                    <?= esc($v[0]) ?> </a><br />
                <sup><?= esc($v['M_dateheure_message']) ?></sup><br />

                message :<br />
                <div>
                    <?= esc($v['M_texte_message']) ?>
                </div>
                <sup>id annonce : <?= esc($v['A_idannonce']) ?></sup>
                <form action="contact" method="post">
                    <?= csrf_field() ?>    
                    <textarea name="message" cols="40" rows="2"></textarea><br />
                    <input type="submit" name="act" value="Repondre" />
                    <input type="hidden" name="idAnnonce" value=<?= esc($v['A_idannonce']) ?> /><br />
                    <input type="hidden" name="idUser" value=<?= esc($v['U_mail']) ?> /><br />
                </form>
            </div>


        <?php endforeach; ?>
    <?php else : ?>
        <h3>Pas de message</h3>
    <?php endif ?>
</div>