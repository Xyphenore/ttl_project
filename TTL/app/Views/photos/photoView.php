
<hr/>
<h2><?= esc($photo['P_titre']) ?></h2>
<hr/>

Photo : <br/>
<?php echo' <img src = "data:image/png;base64,' 
. base64_encode($photo['P_data']) . '" width = "800px" height = "600px"/>'?> </a></p>
           
<br/>
<br/>


