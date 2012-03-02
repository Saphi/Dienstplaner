<?php
if(isset($_GET['seite'])) $seite = $_GET['seite'];
else $seite = 'mitarbeiter';

if(isset($_GET['sub'])) $sub = $_GET['sub'];
else $sub = 'uebersicht';

$handle = fopen ("./ext/help.csv","r");

$row = 1; 
// Anzahl der Arrays
while ( ($data = fgetcsv ($handle, 10000, ";")) !== FALSE ) { // Daten werden aus der Datei
                                               // in ein Array $data gelesen             
   		
       $helptext[$data[0]][$data[1]]= $data[2];           

   
}
fclose ($handle);


?>

<div id="hilfe">
    <div id="hilfe_content">
        
        <?php
            echo $helptext[$seite][$sub];
        ?>
        
    </div>
</div>