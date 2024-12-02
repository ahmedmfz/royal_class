<?php

namespace Modules\General\Http\Middleware;

use App\Services\ModuleHelperService;
use Closure;
use Illuminate\Http\Request;

class ModuleSecurity
{
    
    /**
     * Handle an incoming request.
    */
    public function handle(Request $request, Closure $next)
    {
        // Check if the General module is enabled
        if (!ModuleHelperService::isEnabled('General')) {
            return response()->json(['error' => 'Module is disabled'], 403);
        }

        return $next($request);
    }
    
}