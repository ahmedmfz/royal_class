<?php

use App\Http\Controllers\Api\DocumentController;
use Illuminate\Support\Facades\Route;


Route::get('/documents/versions/{documentHeader}', [DocumentController::class , 'getDocumentVersion']);
Route::delete('/documents/{documentHeader}', [DocumentController::class , 'deleteDocument']);
Route::post('/documents/search', [DocumentController::class , 'searchInDocument']);
