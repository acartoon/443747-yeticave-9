<?php
require_once 'functions.php';
require_once 'bd.php';

$categories = get_categories($link);
$lots = get_lots($link);

$id_name = 2;
?>