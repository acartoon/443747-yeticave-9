<?php
require_once 'init.php';
require_once('vendor/autoload.php');
$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");
$mailer = new Swift_Mailer($transport);
$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

$request = 'SELECT o.*, v.date_end, u.NAME as user_name, u.email, v.name
FROM `rates` o                    
LEFT JOIN `rates` b            
ON o.lot = b.lot AND o.price < b.price
INNER JOIN lots v  ON o.lot = v.id
JOIN users u ON o.user = u.id 
WHERE b.price is NULL AND v.date_end <= NOW() AND v.winner IS null';

$lots = get_data($request, $link);

if(empty($lost)) {
    foreach ($lots as $lot) {
        $request = 'UPDATE lots SET winner = ' . $lot['user'] . ' WHERE id = ' . $lot['lot'];

        $stmt = db_get_prepare_stmt($link, $request);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        $message = new Swift_Message();
        $message->setSubject("Ваша ставка победила");
        $message->setFrom(['keks@phpdemo.ru' => 'YetiCave']);
        $message->setTo($lot['email']);
        $msg_content = include_template('email.php', ['lot' => $lot]);
        $message->setBody($msg_content, 'text/html');
        $result = $mailer->send($message);
    }
}
?>