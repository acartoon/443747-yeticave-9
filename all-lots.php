<?php
require_once 'init.php';
$lots = [];
$category = [''];
$pages_count = '';
$pages = '';
$cur_page = '';
$page_items = 9;
$message = 'В данной категории нет лотов!';

if (isset($_GET['category'])) {
    $category = [
        htmlspecialchars($_GET['category'])
    ];

    if (isset($_GET['page'])) {
        $cur_page = intval($_GET['page']) ?? 1;
    }

    $request = "SELECT COUNT(*) AS count
    FROM lots l
    JOIN categories c
    ON category = c.id
    WHERE l.date_end > CURDATE() AND category = (?)
    ORDER BY l.date_create DESC";

    $result = get_data($request, $link, $category);
    $stmt = db_get_prepare_stmt($link, $request, $category);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);
    $items_count = mysqli_fetch_assoc($res)['count'];

    if ($items_count !== 0) {
        $pages_count = ceil($items_count / $page_items);

        if ($cur_page <= 0) {
            $cur_page = 1;
        } elseif ($cur_page > $pages_count) {
            $cur_page = $pages_count;
        }
        $offset = ($cur_page - 1) * $page_items;

        $pages = range(1, $pages_count);

        $request = 'SELECT l.id, l.name, l.initial_price, l.image_link, l.description, l.step_rate as rate, 
            IFNULL(MAX(r.price), l.initial_price) AS price, IFNULL(MAX(r.price) + l.step_rate, l.initial_price + l.step_rate) AS min_price,c.NAME AS category, l.date_create, l.date_end, l.user
            From lots l
            left JOIN rates r ON r.lot = l.id
            left JOIN categories c ON l.category = c.id
            WHERE category = (?)
            and l.date_end > NOW()
            GROUP BY l.id
            ORDER BY l.date_create ASC
            LIMIT ' . $page_items . ' OFFSET ' . $offset;

        $stmt = db_get_prepare_stmt($link, $request, $category);
        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);
        if ($res) {
            $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $message = "Все лоты в категории <span>«" . $lots[0]['category'] . "»</span>";
        }
    }
}

$main_content = include_template('all-lots.php', [
    'categories' => $categories,
    'lots' => $lots,
    'pages_count' => $pages_count,
    'pages' => $pages,
    'cur_page' => $cur_page,
    'message' => $message,
    'category' => $category[0]
]);
$index_page = include_template('layout.php',
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Поиск']);

print $index_page;
