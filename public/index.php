<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AlarmController;

// (swap for date('D') to use the real current day)
$today = "Wed";

$controller = new AlarmController();
/* The following reads as: 
Label
Time
Days
Enabled
Sound
*/ 
$controller->show(
    "Wake up",
    "07:00",
    ["Mon", "Wed", "Fri"],
    true,
    "Radar",
    $today
);

$alarm = new App\Models\Alarm("Wake up", "07:00", ["Mon", "Wed", "Fri"], true, "Radar");
// For below: snooze 07:00 -> 07:15
echo "\n" . $alarm->snooze(15) . "\n";