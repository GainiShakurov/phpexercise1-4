<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Информер погоды</title>
    <style>
        td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<?php

$link = 'http://api.openweathermap.org/data/2.5/weather';
$city = 'Pavlodar';
$appid = '12c1d44f59e82792981ca76465c94d56';
$url = "$link?q=$city&appid=$appid";

$json = file_get_contents($url);

if ($json === false) {
    exit('Не удалось получить данные');
}

file_put_contents('./temp.txt', $json);
$obj = json_decode(file_get_contents('temp.txt'), true);

if ($obj === null) {
    exit('Ошибка декодирования json');
}

$arrayWeather = [
    "Город" => (!empty($obj['name'])) ? $obj['name'] : 'Название города не найдено',
    "Температура" => round((!empty($obj['main']['temp'])) ? $obj['main']['temp'] : 'Температура не указана' - 273) . '&deg;С',
    " " => (!empty($obj['weather'][0]['icon'])) ? '<img src=icons/' . $obj['weather'][0]['icon'] . '.png>' : 'Иконка погоды не указана',
    "Описание" => (!empty($obj['weather'][0]['description'])) ? $obj['weather'][0]['description'] : 'Описание не указано',
    "Давление" => (!empty($obj['main']['pressure'])) ? $obj['main']['pressure'] . ' mbar' : 'Давление не указано',
    "Влажность" => (!empty($obj['main']['humidity'])) ? $obj['main']['humidity'] : 'Влажность не указана',
    "Скорость ветра" => (!empty($obj['wind']['speed'])) ? $obj['wind']['speed'] . ' м/с' : 'Скорость ветра не указана',
    "Рассвет" => (!empty($obj['sys']['sunrise'])) ? gmdate("Y-m-d\ T H:i:s\\", $obj['sys']['sunrise']) : 'Время рассвета не указано',
    "Закат" => (!empty($obj['sys']['sunset'])) ? gmdate("Y-m-d\ T H:i:s\\", $obj['sys']['sunset']) : 'Время заката не указано',
];

echo '<h3>Город ' . $arrayWeather['Город'] . '</h3>';
echo '<table><tbody>';

foreach ($arrayWeather as $key => $value) {
    echo '<tr>';
    echo '<td><b>' . $key . '</b></td><td>' . $value . '</td>';
    echo '</tr>';
}

echo '</tbody></table>';
?>

</body>
</html>