<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:mysql
                            {--fresh : Drop all tables and re-run}
                            {--seed : Seed after migrating}
                            {--rollback : Rollback last batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate MySQL database';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $this->info('Migrating MySQL database...');
        $options = [
            '--database' => 'mysql',
            '--path' => 'database/migrations/mysql',
            '--force' => true,
        ];

        if ($this->option('fresh')) {
            Artisan::call('migrate:fresh',$options);
        } elseif ($this->option('rollback')) {
            Artisan::call('migrate:rollback',$options);
        } else {
            if ($this->option('seed')) {
                $options['--seed'] = true;
            }
            Artisan::call('migrate', $options);
        }
        $this->info(Artisan::output());
        $this->info('MySQL database migrated successfully.');
    }
}
