<?php

namespace App\Console\Commands;

use App\Services\ModuleHelperService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RunChainedMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
    */
    protected $signature = 'db:run-chained-migrations';

    protected $description = 'Run global migrations first, then resolve and run module migrations with dependencies.';

    protected $visitedModules = []; // To track visited modules and avoid infinite loops

    public function handle()
    {
        $this->info("Starting global migrations...");

        // Run global migrations
        $this->runGlobalMigrations();

        $this->info("Global migrations completed. Starting module migrations...");

        // Fetch all modules
        $modules = ModuleHelperService::ModuleNames();

        foreach ($modules as $moduleName) {
            $this->runModuleMigrations($moduleName);
        }

        $this->info("All migrations completed!");
    }

    protected function runGlobalMigrations()
    {
        $globalPath = database_path('migrations');

        if (is_dir($globalPath)) {
            Artisan::call('migrate', ['--path' => 'database/migrations']);
            $this->info(Artisan::output());
        } else {
            $this->warn("No global migrations found.");
        }
    }

    protected function runModuleMigrations($moduleName)
    {
        // Prevent infinite recursion
        if (in_array($moduleName, $this->visitedModules)) {
            return;
        }

        $this->visitedModules[] = $moduleName;

        // Fetch module details
        $module = DB::table('modules')->where('name', $moduleName)->first();

        if (!$module) {
            $this->error("Module '{$moduleName}' does not exist.");
            return;
        }

        // Resolve dependencies first
        if ($module->depends_on) {
            $this->info("Module '{$moduleName}' depends on '{$module->depends_on}'. Running migrations for '{$module->depends_on}' first.");
            $this->runModuleMigrations($module->depends_on);
        }

        // Run current module migrations
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
            $this->warn("No migrations found for module '{$moduleName}'.");
        }
    }

}
