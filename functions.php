<?php
/**
 * Возвращает целочисленную цену лота с делением на разряды и знаком рубля в конце
 * @param $num число
 * @return  $result форматированная цена для вывода на сайте
 * 
 */
function formatPrice($num) {
    $result = number_format((ceil($num)), 0, '.', ' ');
    $result .= '<b class="rub">р</b>';
    return $result;
};

/**
 * Таймер обратного отсчета до закрытия лота
 * @param $date дата закрытия лота
 * @return  $result срок до окончания лота
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
        $result =  $date;
    }
    return $result;
};

/**
 * Возвращает массив с данными из бд на основании запроса
 * @param $link ресурс соединения с базой данных
 * @param  $request SQL запрос
 * @return $array массив с данными
 * 
 */
function getData($request, $link) {
    $result = mysqli_query($link, $request);
    $array = [];
    if($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $array;
};
?>