<?php  

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\DocumentSearchRequest;
use App\Http\Resources\GlobalCollection;
use App\Models\DocumentHeader;
use App\Services\ApiResponse;

class DocumentController {

    public function getDocumentVersion(DocumentHeader $documentHeader){
        $versions = $documentHeader->versions()->paginate();
        return ApiResponse::returnJSON(new GlobalCollection($versions , 'DocumentVersion'));
    }

    public function deleteDocument(DocumentHeader $documentHeader){
        $documentHeader->bodies()->delete();
        $documentHeader->versions()->delete();
        $documentHeader->delete();
        return ApiResponse::returnSuccess('document deleted successfully');
    }

    public function searchInDocument(DocumentSearchRequest $documentSearchRequest){
        dd($documentSearchRequest->all());
    }

}