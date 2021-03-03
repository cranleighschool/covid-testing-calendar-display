<?php
require_once 'vendor/autoload.php';

use CranleighCovidTestingCalendar\Helper;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
if (isset($_GET['day'])) {
    $day = ucfirst(strtolower($_GET[ 'day' ]));
} else {
    $day = 'Friday';
}


$bays = Helper::getBayCalendarEvents();
$results = [];
foreach (Helper::generateTimesForDay($day) as $date) {
    foreach ($bays as $key => $bay) {
        $results[$date->format("G:i")][$key] = Helper::displayCalendarItem($bay, $date, true);
    }
}
header("Content-Type: application/json");
echo json_encode($results);
die();
