<?php
// pradedame sesiją
session_start();

// panaikiname sesiją
$_SESSION = array();
session_destroy();

// nukreipiame į prisijungimo puslapį
header("location: index.php");
exit;
?>
