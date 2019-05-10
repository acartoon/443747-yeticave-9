<?php
require_once 'functions.php';
require_once 'bd.php';
session_start();
$categories = get_categories($link);
$lots = get_lots($link);

$nav_list = include_template('nav-list.php', ['categories' => $categories]);
?>