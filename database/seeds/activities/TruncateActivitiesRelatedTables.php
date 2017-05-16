<?php

use Illuminate\Database\Seeder;

class TruncateActivitiesRelatedTables extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('activities')->truncate();
        DB::table('activity_assets')->truncate();
        DB::table('activity_materials')->truncate();
        DB::table('activity_observations')->truncate();
        DB::table('activity_procedures')->truncate();
        DB::table('activity_schedule_execution_observations')->truncate();
        DB::table('activity_schedule_executions')->truncate();
        DB::table('activity_schedules')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
