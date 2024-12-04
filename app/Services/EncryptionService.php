<?php 

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;


class EncryptionService
{   
    protected $cipher = 'aes-256-cbc';

    public function encryptDocument($data)
    {
        //Avoid Attack 
        $data  = \htmlspecialchars($data);
        
        // Step 1: Generate a unique encryption key for the document
        $perDocumentKey = \random_bytes(32); // 256-bit key

        // Step 2: Encrypt the per-document key with Laravel's app key
        $encryptedKey = Crypt::encrypt($perDocumentKey);

        // Step 3: Encrypt the header and body data
        $iv = \random_bytes(openssl_cipher_iv_length($this->cipher));
        $encryptedBody = openssl_encrypt($data, $this->cipher, $perDocumentKey, 0, $iv);

        // Store the document in storage (S3 or local)
        $path = 'documents/'. time() . '.txt';
        Storage::put($path, base64_encode($iv . $encryptedBody) , 'public');
        
        return [
            'encryptedKey'   =>  $encryptedKey,
            'storage_path'   =>  $path,
            'preview'        =>  substr($data, 0, 100),
        ];
    }

    public function decryptDocument($documentHeaderObject)
    {
        $perDocumentKey = Crypt::decrypt($documentHeaderObject->encryption_key);
  
        // Step 2: Retrieve the encrypted document from storage
        $encryptedData = base64_decode(Storage::get($documentHeaderObject->body->storage_path));
    
        // Step 3: Extract the IV and encrypted body
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = substr($encryptedData, 0, $ivLength);
        $encryptedBody = substr($encryptedData, $ivLength);

        // Step 4: Decrypt the document body
        $decryptedBody = openssl_decrypt($encryptedBody, $this->cipher, $perDocumentKey, 0, $iv);

        if ($decryptedBody === false) {
            throw new \Exception('Decryption failed. Data may be corrupted or the key is invalid.');
        }
      
        // Step 4: Verify checksum
        if ($this->checksum($decryptedBody) !== $documentHeaderObject->body->checksum) {
            throw new \Exception('Integrity check failed!');
        }

        return $decryptedBody;
    }

    public function checksum($data)
    {
        return hash('sha256', $data);
    }
}