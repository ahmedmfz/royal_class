<?php  

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\DocumentSearchRequest;
use App\Http\Requests\Api\DocumentStoreRequest;
use App\Http\Resources\DocumentHeaderResource;
use App\Http\Resources\GlobalCollection;
use App\Models\DocumentHeader;
use App\Services\ApiResponse;
use App\Services\DocumentService;
use App\Services\EncryptionService;

class DocumentController {

    public function storeDocument(DocumentStoreRequest $documentStoreRequest){
        (new DocumentService(new EncryptionService))->storeDocument([
            'module'     => $documentStoreRequest->module,
            'metadata'   => $documentStoreRequest->metadata ?? [],
            'body'       => $documentStoreRequest->body,
        ]);
        return ApiResponse::returnSuccess('You added Document Successfully');
    }

    public function viewDocument(DocumentHeader $documentHeader){
        return ApiResponse::returnJSON(new DocumentHeaderResource($documentHeader));
    }

    public function getDocumentVersions(DocumentHeader $documentHeader){
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
        $documents = DocumentHeader::when($documentSearchRequest->module , function($q) use($documentSearchRequest){
                                    $q->where('module' , 'LIKE' , "%{$documentSearchRequest->module}%");
                                })
                                ->when($documentSearchRequest->module , function($q) use($documentSearchRequest){
                                        $q->whereJSONContains('metadata->tags' , $documentSearchRequest->tags);
                                })
                                ->when($documentSearchRequest->module , function($q) use($documentSearchRequest){
                                        $q->where('user_id' , "$documentSearchRequest->user_id");
                                })->paginate();
        return ApiResponse::returnJSON(new GlobalCollection($documents , 'DocumentHeader'));
    }

}