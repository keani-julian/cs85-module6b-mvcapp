<?php
// NTS: this view displays the alarm. The controller passes it $alarm, $today, and $next.

echo "My personal alarm scheduler\n";
echo "Alarm: {$alarm->label}\n";
echo "Time: {$alarm->time}\n";
echo "Days: " . implode(", ", $alarm->days) . "\n";
echo "Status: " . ($alarm->enabled ? "Enabled" : "Disabled") . "\n";
echo "Today ({$today}): " . ($alarm->isScheduledFor($today) ? "Scheduled at {$alarm->time}!" : "No alarm today") . "\n";
echo "Next alarm: {$next}\n";
?>