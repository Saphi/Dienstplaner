<?php
/* Session start/holen und zerst�ren. Danach auf anmelden.php weiterleiten
 */
session_start();
session_destroy();
header('Location: anmelden.php');
?>