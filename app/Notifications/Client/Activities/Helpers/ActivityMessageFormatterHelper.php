<?php
namespace App\Notifications\Client\Activities\Helpers;

use Carbon\Carbon;

trait ActivityMessageFormatterHelper
{

    private function getMessageData($user)
    {
        $units = ['addHour', 'addDay', 'addWeek', 'addMonth'];
        $activityName = $this->scheduleExecution->activitySchedule->activity->name;
        $executionDate = Carbon::parse($this->scheduleExecution->execution_date->toDayDateTimeString());
        $executionDate->timezone($user->timezone);
        /** @var Carbon $expirationThreshold */
        $addUnit = $units[$this->scheduleExecution->activitySchedule->estimated_duration_unit];
        $expirationThreshold = $executionDate->copy()->$addUnit($this->scheduleExecution->activitySchedule->estimated_duration);
        $profilePictureThumb = $user->getFirstMediaUrl('profile', 'thumbnail');
        Carbon::setLocale('es');
        $data = [
            'status'                         => [
                'name'     => $this->scheduleExecution->status->name,
                'severity' => $this->scheduleExecution->status->severity
            ],
            'execution_date'                 => $executionDate->format('d/m/Y h:i A'),
            'executed_date'                  => $this->scheduleExecution->executed_date,
            'executed'                       => $this->scheduleExecution->executed,
            'expirationThreshold'            => $expirationThreshold->toDateTimeString(),
            'activity_id'                    => $this->scheduleExecution->activitySchedule->activity_id,
            'activity_schedule_id'           => $this->scheduleExecution->activitySchedule->id,
            'activity_schedule_execution_id' => $this->scheduleExecution->id,
            'notification_date'              => Carbon::now()->toDayDateTimeString(),
            'created_by'                     => $user->id
        ];
        return [$activityName, $data];
    }

}