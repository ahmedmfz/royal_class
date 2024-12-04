<?php 
namespace App\Http\Controllers;

use App\Http\Requests\DocumentStoreRequest;
use App\Models\DocumentBody;
use App\Models\DocumentHeader;
use App\Services\DocumentEncryptionService;
use App\Services\DocumentService;
use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DocumentController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService   = $documentService;
    }

    public function store(DocumentStoreRequest $documentStoreRequest)
    {
        $this->documentService->storeDocument($documentStoreRequest->validated());
        return response()->json(['message' => 'Document stored successfully']);
    }           
}