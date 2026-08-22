<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\CleanupFeaturedJobs::class,
        Commands\GenerateSitemap::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('featured:cleanup')->daily();
        $schedule->command('seo:generate-sitemap')->dailyAt('02:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
