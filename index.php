<?php

require_once 'helpers.php';

$is_auth = rand(0, 1);

$user_name = 'Секрет'; // укажите здесь ваше имя


$category = [
    0 => [
        'class' => 'boards',
        'name' => 'Доски и лыжи'
    ],
    1 => [
        'class' => 'attachment',
        'name' => 'Крепления'
    ],
    2 => [
        'class' => 'boots',
        'name' => 'Ботинки'
    ],
    3 => [
        'class' => 'clothing',
        'name' => 'Одежда'
    ],
    4 => [
        'class' => 'tools',
        'name' => 'Инструменты'
    ],
    5 => [
        'class' => 'other',
        'name' => 'Разное'
    ]
];

$lots = [
    $lot1 = [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '10999',
        'URL' => 'img/lot-1.jpg'
    ],
    $lot2 = [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '159999',
        'URL' => 'img/lot-2.jpg'
],
    $lot3 = [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => '8000',
        'URL' => 'img/lot-3.jpg'
],
    $lot4 = [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => '10999',
        'URL' => 'img/lot-4.jpg'
],
    $lot5 = [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => '7500',
        'URL' => 'img/lot-5.jpg'
],
    $lot6 = [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => '5400',
        'URL' => 'img/lot-6.jpg'
    ]
];


//module2-task2

$formatNumber = function($num) {
    $result = number_format((ceil($num)), 0, '.', ' ');
    $result .= '<b class="rub">р</b>';
    return $result;
};

// function formatNumber($num) {
//     $noFloat = ceil($num);
//     //print 'строка'.$noFloat;
//     $part1 = substr($nofloat, 0, -3);
//     $part2 = substr($nofloat, -3, 3);
//    // $result = $part1 .' '. $part2 . ' ' .'₽';
//     $result = $part2;
//     return $result;
// };
$main_content = include_template('index.php', ['category' => $category, 'lots' => $lots, 'formatNumber' => $formatNumber]);

$index_page = include_template('layout.php', 
['category' => $category, 'main_content' => $main_content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name]);


print $index_page;
?>


