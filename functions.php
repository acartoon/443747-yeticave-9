<?php


require_once 'helpers.php';
/**
 * Возвращает целочисленную цену лота с делением на разряды и знаком рубля в конце
 * @param float $num число, требующее форматирования
 * @return string форматированная цена для вывода на сайте
 * 
 */
function format_price($num) {
    $result = number_format((ceil($num)), 0, '.', ' ');
    $result .= '<b class="rub">р</b>';
    return $result;
};

/**
 * Таймер обратного отсчета до закрытия лота
 * @param string $date дата закрытия лота в виде строки
 * @return string срок до окончания лота
 * 
 * Если дата окончания лота меньше текущей даты возвращает строку 'лот закрыт'
 * Если до окончания меньше 1 дня возвращает часы и минуты до закрытия лота
 * Если до окончания от  1 до 5 дней возвращает количество дней до закрытия лота
 * Если до окончания более 5 дней возвращает дату закрытия лога
 */
function timer($date) {
    $dt_end = date_create($date);
    $dt_now = date_create("now");
    $dt_diff = date_diff($dt_now, $dt_end);
    $timer_days = date_interval_format($dt_diff, "%a");
    $result = '';
   
    if($dt_now > $dt_end) {
        $result = 'лот закрыт';
    } elseif($timer_days < 1 and $dt_now < $dt_end) {
        $result =  date_interval_format($dt_diff, "%h ч %i мин");
    } elseif(0 < $timer_days and $timer_days < 6) {
        $result =  date_interval_format($dt_diff, "%d дн");
    } elseif(5 < $timer_days) {

        $result =  date('j-n-y', strtotime($date));
    }
    return $result;
};

/**
 * Проверяет, что переданная дата больше текущей даты
 * @param string $date дата в виде строки
 * @return boolean true если дата предстоящая, false если прошедшая
 */
function check_date($date) {
    $check_date = date_create($date);
    $dt_now = date_create("now");
    $result = false;
   
    if($dt_now > $check_date) {
        $result = true;
    }
    return $result;
};

/**
 * Возвращает массив с данными из бд на основании запроса
 * @param mysqli $link ресурс соединения с базой данных
 * @param  string $request SQL запрос
 * @return array массив с данными
 * 
 */

function get_data($request, $link) {
    $result = mysqli_query($link, $request);
    $array = [];
    if($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $array;
};

/**
 * Возвращает массив с лотами
 * @param mysqli $link ресурс соединения с базой данных
 * @return array $result массив с лотами
 * 
 */
function get_lots($link) {
    $request = "SELECT l.id, l.name as name, c.name as category, initial_price as price, image_link as URL, date_end
    FROM lots l
    JOIN categories c
    ON category = c.id
    WHERE l.date_end > CURDATE()
    ORDER BY l.date_create DESC
    LIMIT 6";
    
    $result = get_data($request, $link);
    return $result;
};

/**
 * Возвращает массив с категориями
 * @param mysqli $link ресурс соединения с базой данных
 * @return array $result массив с категориями
 */
function get_categories($link) {
    $request = "SELECT id, character_code, name FROM categories";
    $result = get_data($request, $link);
    return $result;
};

/**
 * Возвращает многомерный массив с лотами и числом рядов в результирующей выборке
 * @param mysqli $link ресурс соединения с базой данных
 * @return array многомерный массив с лотом $lot и числом рядов в результирующей выборке $count
 */
function get_lot($link, $get) {
    $request = 'SELECT l.id, l.name, l.initial_price, l.image_link, l.description, l.step_rate as rate, 
    IFNULL(MAX(r.price), l.initial_price) AS price, IFNULL(MAX(r.price) + l.step_rate, l.initial_price + l.step_rate) AS min_price,c.NAME AS category, l.date_create, l.date_end, l.user
    From lots l
    left JOIN rates r ON r.lot = l.id
    left JOIN categories c ON l.category = c.id
    WHERE l.id = (?) GROUP BY l.id';
    $lot = [];
    $count = 0;

    $stmt = db_get_prepare_stmt($link, $request, $get);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($res) {
        $lot = mysqli_fetch_assoc($res);
        $count = mysqli_num_rows($res);
    }
    $result = ['lot' => $lot, 'count' => $count];
    return $result;
};

function get_rates($link, $get) {
    // $result = [];
    $request = "SELECT r.id, r.date_create, r.price, r.lot, r.user as id_user, u.name  FROM rates r
    JOIN users u ON r.user = u.id
    WHERE lot = (?)
    ORDER BY r.date_create DESC";
    $stmt = db_get_prepare_stmt($link, $request, $get);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
}

function get_rates_for_user($link, $id) {
    // $result = [];
    $request = "SELECT l.NAME, l.image_link, l.id, c.NAME AS category, l.date_end, r.price, r.date_create, r.user
    FROM rates r
    JOIN lots l ON l.id = r.lot
    JOIN categories c ON l.category = c.id
    WHERE r.USER = (?)
    ORDER BY r.date_create DESC";
    $stmt = db_get_prepare_stmt($link, $request, $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
}

/**
 * Возвращает класс 'timer--finishing', если времени осталось меньше суток
 * @param mysqli $link ресурс соединения с базой данных
 * @param  string $request SQL запрос
 * @return array $array массив с данными
 *  */
function check_passed_date($date) {
    $dt_end = date_create($date);
    $dt_now = date_create("now");
    $dt_diff = date_diff($dt_now, $dt_end);
    $timer_days = date_interval_format($dt_diff, "%a");
    $result = false;

    if($timer_days < 1 and $dt_now < $dt_end) {
        $result = true;
    };

    return $result;
};
/**
 * Возвращает код ошибки сервера и шаблон согласно коду ошибки
 * @param string $error_code код ошибки
 * @param string $error_page название шаблона ошибки в папке templates
 * @param string $title заголовок страницы
 * @param string $categories массив с категориями
 * 
 *  */
function error($error_code, $error_page, $title, $categories) {
    http_response_code($error_code);
    $main_content = include_template($error_page);
    $index_page = include_template('layout.php', 
        ['categories' => $categories, 'main_content' => $main_content, 'title' => $title]);
    print $index_page;
    exit();
}

?>