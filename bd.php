<?php
$link = mysqli_connect("localhost", "root", "", "yeticave_443747");

if ($link === false) {
    $index_page = include_template('error.php');
    print $index_page;
    exit();
};
mysqli_set_charset($link, "utf8");