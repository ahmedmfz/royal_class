<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class MigrateModuleCommand extends Command
{
    protected $signature = 'migrate:module {module}';
    protected $description = 'Run migrations for a specific module if it is enabled';

    public function handle()
    {
        $moduleName = $this->argument('module');

        // Fetch module details
        $module = DB::table('modules')->where('name', $moduleName)->first();

        if (!$module) {
            $this->error("Module '{$moduleName}' does not exist.");
            return 1;
        }

        if ($module->depends_on) {
            $this->info("Module '{$moduleName}' depends on '{$module->depends_on}'. Running migrations for '{$module->depends_on}' first.");
            Artisan::call('migrate:module', ['module' => $module->depends_on]);
            $this->info(Artisan::output());
        }

        // Run the current module's migrations
        $this->info("Running migrations for module: {$moduleName}");
        $migrationPath = base_path("Modules/{$moduleName}/Database/Migrations");

        if (is_dir($migrationPath)) {
            Artisan::call('migrate', ['--path' => "Modules/{$moduleName}/Database/Migrations"]);
            $this->info(Artisan::output());

            // Update the last_migrated_at timestamp
            DB::table('modules')->where('name', $moduleName)->update([
                'last_migrated_at' => now(),
            ]);

            $this->info("Migrations for module '{$moduleName}' completed.");
        } else {
            $this->error("No migrations found for module '{$moduleName}'.");
        }

        return 0;
    }
}
