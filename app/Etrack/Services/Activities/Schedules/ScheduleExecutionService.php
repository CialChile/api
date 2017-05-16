<?php
namespace App\Etrack\Services\Activities\Schedules;

use App\Etrack\Entities\Auth\User;
use Carbon\Carbon;

class ScheduleExecutionService
{

    public function nextExecutionDate($scheduleConfig, $hasBeenExecuted = false)
    {
        $periodicity = $scheduleConfig['periodicity'];
        $frequency = $scheduleConfig['frequency']['slug'];
        $days = collect($scheduleConfig['days']);
        $dayOfMonth = $scheduleConfig['dayOfMonth'];
        $startTime = Carbon::parse($scheduleConfig['initHour']);
        $sunday = $days->pop();
        $days->prepend($sunday);
        $days = $days->flatten()->toArray();
        $now = Carbon::now()->setTime(0, 0, 0);
        $now->setTime($startTime->hour, $startTime->minute, $startTime->second);
        if ($frequency == 'daily') {
            $now->addDay(1);
            if ($hasBeenExecuted) {
                $now->addDay($periodicity);
            }
            return $now;
        }

        if ($frequency == 'weekly') {
            $nextDay = null;
            for ($i = 0; $i <= 6; $i++) {
                if ($days[$i]) {
                    if ($i > $now->dayOfWeek) {
                        $nextDay = $i;
                        break;
                    }
                }
            }
            if (!$nextDay) {
                for ($i = 0; $i <= 6; $i++) {
                    if ($days[$i]) {
                        $nextDay = $i;
                        break;
                    }
                }
            }
            $now->next($nextDay);
            if ($hasBeenExecuted) {
                $now->addWeek($periodicity);
            }
            $now->setTime($startTime->hour, $startTime->minute, $startTime->second);
            return $now;
        }

        if ($frequency == 'monthly') {
            $daysInMonth = $now->daysInMonth;

            $dayOfMonth = $dayOfMonth <= $daysInMonth ? $dayOfMonth : $daysInMonth;
            if ($dayOfMonth < $now->day) {
                $now->addMonths(1)->day($dayOfMonth);
            }
            if ($hasBeenExecuted) {
                $now->addMonths($periodicity);
            }
            $now->setTime($startTime->hour, $startTime->minute, $startTime->second);
            return $now;
        }
    }

    public function scheduleEnd(Carbon $date, $duration, $durationUnit)
    {
        $units = ['Hours', 'Days', 'Weeks', 'Months'];
        $date = $date->copy();
        $durationModifier = 'add' . $units[$durationUnit];
        $date->$durationModifier($duration);

        return $date;

    }
}