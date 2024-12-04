<?php

use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\ModuleController;
use Illuminate\Support\Facades\Route;


Route::get('/documents/{documentHeader}', [DocumentController::class , 'viewDocument']);
Route::get('/documents/versions/{documentHeader}', [DocumentController::class , 'getDocumentVersions']);
Route::delete('/documents/{documentHeader}', [DocumentController::class , 'deleteDocument']);
Route::post('/documents/search', [DocumentController::class , 'searchInDocument']);
Route::post('/modules/migrate', [ModuleController::class , 'moduleMigrate']);
Route::post('/documents', [DocumentController::class , 'storeDocument']);
