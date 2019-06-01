<?php
require_once 'init.php';
$lots = [];
$search = [];
$pages_count = '';
$pages = '';
$cur_page = '';
$search = [''];
$message = 'По вашему запросу ничего не найдено!';

if (isset($_GET['search'])) {
    $search = [
        $_GET['search']
    ];

    if (isset($_GET['page'])) {
        $cur_page = intval($_GET['page']) ?? 1;
    }


    $page_items = 6;

    $sql = 'SELECT COUNT(*) as count FROM lots
    WHERE MATCH(name, description) AGAINST(?) and date_end > NOW()';

    $stmt = db_get_prepare_stmt($link, $sql, $search);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);
    $items_count = mysqli_fetch_assoc($res)['count'];

    $pages_count = ceil($items_count / $page_items);

    if ($cur_page <= 0) {
        $cur_page = 1;
    } elseif ($cur_page > $pages_count) {
        $cur_page = $pages_count;
    }
    $offset = ($cur_page - 1) * $page_items;
    $pages = range(1, $pages_count);

    $request = 'SELECT l.id, l.name, l.initial_price, l.image_link, l.description, l.step_rate as rate, 
        IFNULL(MAX(r.price), l.initial_price) AS price, c.NAME AS category, l.date_create, l.date_end, l.user, COUNT(r.price) AS count_rates
        From lots l
        left JOIN rates r ON r.lot = l.id
        left JOIN categories c ON l.category = c.id
        WHERE MATCH(l.name,l.description) AGAINST(?)
        and l.date_end > NOW()
        GROUP BY l.id
        ORDER BY l.date_create ASC
        LIMIT ' . $page_items . ' OFFSET ' . $offset;

    $stmt = db_get_prepare_stmt($link, $request, $search);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $lots_count = count($lots);

        if ($lots_count > 0) {
            $message = 'Результаты поиска по запросу «<span>' . htmlspecialchars($search[0]) . '</span>»';
        }
    }
}

$main_content = include_template('search.php', [
    'categories' => $categories,
    'lots' => $lots,
    'message' => $message,
    'pages_count' => $pages_count,
    'pages' => $pages,
    'cur_page' => $cur_page,
    'search' => $search[0]
]);
$index_page = include_template('layout.php',
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Поиск', 'search' => $search[0],]);

print $index_page;
