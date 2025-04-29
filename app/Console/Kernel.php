<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SyncGlpiInventoryCommand; // Asegúrate de que esta línea exista si no está

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Aquí Laravel lista tus comandos personalizados
        // Debes añadir la línea de tu comando aquí:
        SyncGlpiInventoryCommand::class, // <--- ¡Añade esta línea!
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // Si quisieras programar tu comando, lo harías aquí, por ejemplo:
        // $schedule->command('glpi:sync-inventory')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
