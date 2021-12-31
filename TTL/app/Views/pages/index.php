<h2><?= esc($title) ?></h2>
<div>
    Accessible à tous<br/>
    En construction

    <?php
        $session = session();

        if ( isset($session) ) {
            echo "Bonjour " . $session->upseudo;
        }
    ?>
</div>