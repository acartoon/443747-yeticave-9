<?php

function formatPrice($num) {
    $result = number_format((ceil($num)), 0, '.', ' ');
    $result .= '<b class="rub">р</b>';
    return $result;
};

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
?>