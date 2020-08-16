<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/8/16
 * Time: 10:50
 */

namespace App\Services\Hot;

use App\Jobs\Test;
use App\Services\OrderService;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleService
{
    public static function boot(Schedule $schedule)
    {
        self::job($schedule);
    }

    public static function job(Schedule $schedule)
    {
        $schedule->job(new Test())->everyMinute();
    }

    public static function call(Schedule $schedule)
    {
        $schedule->call(function () {
            OrderService::dayTotal();
        })->daily();
    }

}
