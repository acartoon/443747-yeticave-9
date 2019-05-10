<?php
require_once 'functions.php';
require_once 'bd.php';

$categories = get_categories($link);
$lots = get_lots($link);

$name = 2;

$user_name = 'Секрет';
?>