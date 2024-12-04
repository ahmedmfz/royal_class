<?php  

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\ModuleRequest;
use App\Services\ApiResponse;
use Illuminate\Support\Facades\Artisan;

class ModuleController {

    public function moduleMigrate(ModuleRequest $moduleRequest){
        Artisan::call('migrate:module', ['module'=>$moduleRequest->module]);
        return ApiResponse::returnSuccess("$moduleRequest->module module migrated successfully");
    }

}