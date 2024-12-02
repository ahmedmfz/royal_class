<?php  

namespace App\Services;

use Illuminate\Support\Facades\DB;

class  ModuleHelperService {

    /**
     * pluck modules Names.
     *
     * @return array
    */
    public static function ModuleNames(): array
    {
        return DB::table('modules')
                    ->pluck('name')
                    ->toArray();
    }

    /**
     * Check if a module is enabled.
     *
     * @param string $moduleName
     * @return bool
    */
    public static function isEnabled(string $moduleName): bool
    {
        return DB::table('modules')
            ->where('name', $moduleName)
            ->where('enabled', true)
            ->exists();
    }

}