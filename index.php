<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$bays = \App\Helper::getBayCalendarEvents();

?>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
        .house-north {
            background: red;
        }
        .house-cubitt {
            background: green;
        }
        .house-east {
            background: lightblue;
        }
        div.calendar-item>span {
            display: block;
        }
        div.calendar-item {
            border-radius: 4px;
            padding:5px;
        }
    </style>
</head>
<body>
    <table class="table table-striped">
        <thead>
        <th>Time</th>
        <?php foreach ([1, 2, 3, 4, 5] as $bay) {
            echo "<th>Bay ".$bay."</th>";
        }
        ?>
        </thead>
        <?php

        foreach (\App\Helper::generateTimesForDay('Friday') as $date) {
            echo "<tr>";
            echo "<th>".$date->format("G:i")."</th>";
            foreach($bays as $bay) {
                echo "<td>".(\App\Helper::displayCalendarItem($bay, $date))."</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>

