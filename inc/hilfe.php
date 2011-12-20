<?php
if(isset($_GET['seite'])) $seite = $_GET['seite'];
else $seite = 'mitarbeiter';

if(isset($_GET['sub'])) $sub = $_GET['sub'];
else $sub = 'uebersicht';

$hilfe=mysql_fetch_assoc(mysql_query("SELECT text FROM hilfe WHERE seite='".$seite."' AND sub='".$sub."'"));

?>

<div id="hilfe">
    <div id="hilfe_content">
        
        <?php
            echo $hilfe['text'];
        ?>
        
    </div>
</div>