<?php
require 'DB.Config.php';

$id = $_GET['id'];

$queryDelete = 'DELETE FROM `person` WHERE `id` = ' . $id . '';
$result = $link->query($queryDelete);

$link->close();
header('Location: employees.php');
?>
