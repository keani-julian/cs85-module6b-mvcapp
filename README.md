# cs85-module6b-mvcapp

## Includes: 
- App description
- Setup instructions
- Reflection
- AI critique

## App description


## Setup instructions


## AI code review & critique
### Choose 1 function or method: 
I chose a method for snoozing the alarm.

### My prompt:
"Write a PHP method for my Alarm class that snoozes the alarm by a given number of minutes and updates the $time property (which is in "HH:MM" format)."

### Raw AI output:
public function snooze($minutes) {
        $parts = explode(":", $this->time);
        $hour = $parts[0];
        $minute = $parts[1];
        $minute = $minute + $minutes;
        if ($minute >= 60) {
            $hour = $hour + 1;
            $minute = $minute - 60;
        }
        $this->time = $hour . ":" . $minute;
        return "Snoozed to " . $this->time;
}

### My critique: what worked, what didn't, & changes
**What worked:** 

The overall approach is fine. Splitting the time on the colon with explode() and adding the minutes is how I'd start. For a small snooze like 5 or 10 minutes that stays within the same hour, it gives the right answer.

**What didn't:**

The single if ($minute >= 60) only rolls over once, so snoozing by 70+ minutes leaves the minutes above 60. It also never handles the hour rolling past 23, so noozing an 11:50 PM alarm gives "24:xx" instead of wrapping to the next day. And there's no zero-padding, so I'd get "7:5" instead of "07:05", which actually breaks the "HH:MM" format my validation depends on. 

It also trusts the input blindly (a negative or non-number wouldn't show a valid output).

**Changes I made:**

I converted everything to total minutes, used % 1440 (minutes in a
day) so it wraps cleanly past midnight, split it back out with intdiv, and used sprintf("%02d:%02d", intdiv($total, 60), $total % 60); to keep the zero-padded format. 

I also added a guard that rejects a snooze value that isn't a positive number.

**My revised version:**

The following Snoozes the alarm forward by X minutes (wraps past midnight, keeps HH:MM)

> public function snooze($minutes) {

    if (!is_numeric($minutes) || $minutes <= 0) {

        return "Snooze amount must be a positive number.";

    }

    list($hour, $minute) = explode(":", $this->time);

    $total = ((int)$hour * 60 + (int)$minute + (int)$minutes) % 1440;

    $this->time = sprintf("%02d:%02d", intdiv($total, 60), $total % 60);

    return "Snoozed to {$this->time}";
    
    }


## Reflection 
- Why I chose my topic

I chose to build an alarm and reminder scheduler because it's something I interact with every single day. I rely on recurring alarms to wake up, handle meetings at work and generally to stay on track as I experience ADHD tendancies, so modeling one felt more meaningful and insightful for me.

- What my app does

My app lets you label an alarm with a label, a time, the days it should go off, whether it's enabled, and a sound. When you run it, the controller validates the input (checking the time is in proper HH:MM format and that the days are real weekdays), builds an Alarm object, and hands it to the view to print a clean summary, while including whether it's scheduled for the current day and what the next ringing day will be. I also added a snooze method that pushes the alarm time forward by a set number of minutes and correctly wraps past midnight.

- The hardest part and why

The hardest part for me was the setup and autoloading. I kept running into problems that had nothing to do with my actual code: my class wouldn't load because I named the file alarm-controller.php instead of AlarmController.php, and PSR-4 requires the filename to match the class name exactly. 

I also got a confusing "namespace must be the first statement" error just because I'd put a comment above the <?php tag. 

On top of that, I had issue with Git — I had to set an upstream branch and merge unrelated histories before I could push. Each of these was small on its own, but together they taught me that a big part of real development is getting the environment and conventions right the first time around carefully, not just writing functions.

- What I learned about MVC

    - How much cleaner it makes the code by separating concerns. 
    - My Model only knows about alarm data and rules, my View only worries about printing, and my
    - Controller is the glue that validates input and connects the two. 
    - At first it felt like more files than necessary for a small app, but I could see how it would scale — if I wanted
    to add a web form or a database later, I'd only touch the piece responsible for that, and the rest would stay untouched. 
    - Composer's autoloading tied it together by letting me use a
    class with a single "use" statement instead of a pile of require_once lines.


- My critique of the AI-generated code

    - Refer to the above "My critique: what worked, what didn't, & changes"
