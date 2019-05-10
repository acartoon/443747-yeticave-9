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
    $request = 'SELECT l.name, l.initial_price, l.image_link, l.description, 
    IFNULL(MAX(r.price), l.initial_price) AS price, c.NAME AS category, l.date_create, l.date_end
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

/**
 * Возвращает класс 'timer--finishing', если времени осталось меньше суток
 * @param mysqli $link ресурс соединения с базой данных
 * @param  string $request SQL запрос
 * @return array $array массив с данными
 *  */
function add_class($date) {
    $dt_end = date_create($date);
    $dt_now = date_create("now");
    $dt_diff = date_diff($dt_now, $dt_end);
    $timer_days = date_interval_format($dt_diff, "%a");
    $result = '';

    if($timer_days < 1 and $dt_now < $dt_end) {
        $result = 'timer--finishing';
    };

    return $result;
};
/**
 * Возвращает код ошибки сервера 404
 * Выводит шаблон ошибки 404
 *  */
// function error($error_code, $error_page) {
//     http_response_code($error_code);
//     $index_page = include_template($error_page);
//     print $index_page;
//     exit();
// }

function error($error_code, $error_page, $title, $categories) {
    http_response_code($error_code);
    $main_content = include_template($error_page);
    $index_page = include_template('layout.php', 
        ['categories' => $categories, 'main_content' => $main_content, 'title' => $title]);
    print $index_page;
    exit();
}
?>