<?php

use App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus;
use Illuminate\Database\Seeder;

class ActivityScheduleExecutionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = collect([
            ['name' => 'Programada', 'slug' => 'scheduled', 'severity' => 'info'],
            ['name' => 'Próxima a Ejecutarse', 'slug' => 'next_to_execute', 'severity' => 'warning'],
            ['name' => 'Expirada', 'slug' => 'expired', 'severity' => 'danger'],
            ['name' => 'Ejecutada', 'slug' => 'executed', 'severity' => 'success'],
            ['name' => 'Cancelada', 'slug' => 'canceled', 'severity' => 'danger'],
            ['name' => 'Aprobada', 'slug' => 'approved', 'severity' => 'success'],
            ['name' => 'Necesita Aprobación', 'slug' => 'need_approval', 'severity' => 'warning'],
        ]);

        $status->each(function ($stat) {
            if (!ActivityScheduleExecutionStatus::where('slug', $stat['slug'])->first()) {
                ActivityScheduleExecutionStatus::create($stat);
            }
        });


    }
}
