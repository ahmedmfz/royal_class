<?php 


namespace App\Services;

use App\Models\DocumentHeader;
use Illuminate\Support\Facades\DB;

class DocumentService {
    protected $encryptionService;

    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    public function storeDocument($data)
    {
        DB::transaction(function() use($data){ 
            $encrypted  =  $this->encryptionService->encryptDocument($data['body']);
            $checksum   =  $this->encryptionService->checksum($data['body']);
            $header = DocumentHeader::create([
                'user_id' => 1 ,  //dummy id because we don't have auth feature
                'module' => $data['module'],
                'metadata' => $validated['metadata'] ?? [],
                'encryption_key' => $encrypted['encryptedKey'],
            ]);
            
            $this->storeDocumentBodies($header , $encrypted['storage_path'], $encrypted['preview'] ,  $checksum);
            $this->storeDocumentVersion($header);
        });
    }

    public function storeDocumentBodies($header , $path , $preview , $checksum)
    {
        $header->bodies()->create([
            'storage_path'  => $path,
            'preview'  => $preview,
            'checksum'      => $checksum,
        ]);
    }
        
    public function storeDocumentVersion($header){
        $header->versions()->create([
            'version_number' => 1,
            'changes_summary' => json_encode(['created' => 'Initial document creation']),
        ]);
    }
}