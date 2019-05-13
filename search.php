<?php
require_once 'init.php';
$lots = [];
$search = [''];
$message = 'По вашему запросу ничего не найдено!';
if(isset($_GET['search'])) {
    $search = [
        trim($_GET['search'])  
    ];
    

    $sql = 'SELECT COUNT(*) as count FROM lots
    WHERE MATCH(name, description) AGAINST(?)';

    $stmt = db_get_prepare_stmt($link, $sql, $search);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);
    $items_count = mysqli_fetch_assoc($res)['count'];

    $request = 'SELECT l.id, l.name, l.initial_price, l.image_link, l.description, l.step_rate as rate, 
    IFNULL(MAX(r.price), l.initial_price) AS price, IFNULL(MAX(r.price) + l.step_rate, l.initial_price + l.step_rate) AS min_price,c.NAME AS category, l.date_create, l.date_end, l.user
    From lots l
    left JOIN rates r ON r.lot = l.id
    left JOIN categories c ON l.category = c.id
    WHERE MATCH(l.name,l.description) AGAINST(?)
    and l.date_end > NOW()
    GROUP BY l.id
    ORDER BY l.id ASC
    LIMIT 3';


    $stmt = db_get_prepare_stmt($link, $request, $search);
    mysqli_stmt_execute($stmt);
    
    $res = mysqli_stmt_get_result($stmt);
    $total = $res ? mysqli_fetch_assoc($res): null;

    if($total) {
        $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $message = 'Результаты поиска по запросу «<span>' . htmlspecialchars($search[0]) . '</span>»';
    }
    

    // print_r($items_count);
    print_r($lots);
    
}
$main_content = include_template('search.php', ['categories' => $categories, 'lots' => $lots, 'message' => $message]);
$index_page = include_template('layout.php', 
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Поиск', 'search' => $search[0],]);

print $index_page;
?>