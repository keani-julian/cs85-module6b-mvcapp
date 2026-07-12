<?php

namespace App\Models;

class Alarm {
    public $label;
    // "HH:MM" 24-hour
    public $time;
    // array like ["Mon","Wed","Fri"]
    public $days;
    public $enabled;
    public $sound;

    public function __construct($label, $time, $days, $enabled, $sound) {
        $this->label = $label;
        $this->time = $time;
        $this->days = $days;
        $this->enabled = $enabled;
        $this->sound = $sound;
    }

    // Decision logic: Have alarm set to ring on set day(s)
    public function isScheduledFor($day) {
        return $this->enabled && in_array($day, $this->days);
    }

    // Business rule: find the next day (starting from $fromDay) the alarm should ring
    public function nextOccurrence($fromDay) {
        $week = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
        $start = array_search($fromDay, $week);
        if ($start === false) {
            return "Unknown";
        }
        for ($i = 0; $i < 7; $i++) {
            $day = $week[($start + $i) % 7];
            if ($this->isScheduledFor($day)) {
                return $day;
            }
        }
        return "Never (no active days)";
    }
}