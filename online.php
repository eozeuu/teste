<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include "config/config.php";

$atualizar = date('d/m/Y H:i:s', strtotime('+15 sec'));

@$id = $_SESSION["ID_TRANSACAO"];
$_SESSION['ip'] = $ip = $_SERVER["REMOTE_ADDR"];

global $pdo;

if(isset($_SESSION['ip'])){
$sql = $pdo->prepare("UPDATE infos SET status = '$atualizar'  WHERE id = '$id' ");
$sql->execute();
}


?>


