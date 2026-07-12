<?php
// NTS: must validate input, load the model, and pass data to the view

namespace App\Controllers;

use App\Models\Alarm;

class AlarmController {
    // NTS: The following validates input, loads the model, passes data to the view
    public function show($label, $time, $days, $enabled, $sound, $today) {
        // Validates input
        $errors = [];
        if (trim($label) === "") {
            $errors[] = "Label cannot be empty.";
        }
        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $time)) {
            $errors[] = "Time must be HH:MM 24-hour (e.g., 07:00).";
        }
        $validDays = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
        foreach ($days as $day) {
            if (!in_array($day, $validDays)) {
                $errors[] = "Invalid day: {$day}.";
            }
        }
        if (!empty($errors)) {
            echo "Could not create alarm:\n";
            foreach ($errors as $error) {
                echo " - {$error}\n";
            }
            return;
        }

        // Loads the model
        $alarm = new Alarm($label, $time, $days, $enabled, $sound);

        // Passes data to view
        $next = $alarm->nextOccurrence($today);
        require __DIR__ . '/../../views/alarm-view.php';
    }
}