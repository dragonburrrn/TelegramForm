<?php

// Токен
const TOKEN = '8180342154:AAHRkLwiaUbYGJ3vQTWttuUREU-M80n5y2g';

// ID чата
const CHATID = '-4675095648';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Проверяем не пусты ли поля с email и согласием
    if (!empty($_POST['email']) && isset($_POST['consent'])) {
        
        // Если не пустые, то валидируем эти поля и сохраняем их в тело сообщения
        $txt = "";

        // Email
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $txt .= "Email подписчика: " . strip_tags(trim(urlencode($_POST['email']))) . "%0A";
        }

        // Добавляем информацию о согласии
        if (isset($_POST['consent'])) {
            $txt .= "Согласие на обработку персональных данных: Да%0A";
        }

        // Отправка сообщения в Telegram
        $textSendStatus = @file_get_contents('https://api.telegram.org/bot' . TOKEN . '/sendMessage?chat_id=' . CHATID . '&parse_mode=html&text=' . $txt);

        if (isset(json_decode($textSendStatus)->{'ok'}) && json_decode($textSendStatus)->{'ok'}) {
            echo json_encode('SUCCESS');
        } else {
            echo json_encode('ERROR');
        }
    } else {
        echo json_encode('NOTVALID');
    }
} else {
    header("Location: /");
}
