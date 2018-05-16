<style>

    td {
        vertical-align: middle;
    }

    </style>

<?php

$url = 'http://api.openweathermap.org/data/2.5/weather?q=Pavlodar&appid=12c1d44f59e82792981ca76465c94d56';
$json = file_get_contents($url);
file_put_contents('./temp.txt', $json);
$obj = json_decode(file_get_contents('temp.txt'), true);

$arrayWeather = [
    "Город" => $obj['name'],
    "Температура" => round($obj['main']['temp'] - 273).'&deg;С',
    " " => '<img src=/icons/'.$obj['weather'][0]['icon'].'.png>',
    "Описание" => $obj['weather'][0]['description'],
    "Давление" => $obj['main']['pressure'].' mbar',
    "Влажность" => $obj['main']['humidity'],
    "Скорость ветра" => $obj['wind']['speed']. ' м/с',
    "Рассвет" => gmdate("Y-m-d\ T H:i:s\\", $obj['sys']['sunrise']),
    "Закат" => gmdate("Y-m-d\ T H:i:s\\", $obj['sys']['sunset']),
];

echo '<h3>Город '.$obj['name'].'</h3>';
echo '<table><tbody>';

foreach ($arrayWeather as $key => $value) {
    echo '<tr>';
    echo '<td><b>'.$key.'</b></td><td>'.$value.'</td>';
    echo '</tr>';
}


echo '</tbody></table>';