<h2><?= esc($title) ?></h2>
<div>
    <!-- TODO debug à virer -->
pages/index.php<br/>
    Accessible à tous<br/>
    En construction

    <?php
        $session = session();

        if ( isset($session) ) {
            echo "Bonjour " . $session->upseudo;
        }
    ?>
</div>