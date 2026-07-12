<?php
// NTS: this view displays the alarm. The controller passes it $alarm, $today, and $next.
?>

My personal alarm scheduler
Alarm: <?= $alarm->label ?>
Time: <?= $alarm->time ?>
Days: <?= implode(", ", $alarm->days) ?>
Status: <?= $alarm->enabled ? "Enabled" : "Disabled" ?>

Today (<?= $today ?>): <?= $alarm->isScheduledFor($today) ? "RINGING at {$alarm->time}!" : "no alarm today" ?>

Next alarm: <?= $next ?>