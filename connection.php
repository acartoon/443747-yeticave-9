<?php
require_once 'functions.php';
require_once 'bd.php';

$categories = getCategories($link);

$is_auth = rand(0, 1);

$user_name = 'Секрет';
?>