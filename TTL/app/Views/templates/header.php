<?php

echo '<!doctype html>
        <html>
            <head>
                <title>'.esc($title).'</title>
            </head>
            <body>
            ';
?>
<ht />
NAVBAR EN CONSTRUCTION<br />
<ht />

<?php if (!empty($iduser)) {

    echo 'session en cours : ' . ($iduser);
} else {
    echo 'aucune session';
}
?>