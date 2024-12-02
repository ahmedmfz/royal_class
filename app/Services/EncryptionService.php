<?php 

namespace App\Services;

use Illuminate\Support\Facades\Crypt;


class EncryptionService
{   
    protected $cipher = 'aes-256-cbc';

    public function encryptDocument($data)
    {
        // Step 1: Generate a unique encryption key for the document
        $perDocumentKey = \random_bytes(32); // 256-bit key

        // Step 2: Encrypt the per-document key with Laravel's app key
        $encryptedKey = Crypt::encrypt($perDocumentKey);

        // Step 3: Encrypt the header and body data
        $iv = \random_bytes(openssl_cipher_iv_length($this->cipher));
        $encryptedBody = openssl_encrypt($data, $this->cipher, $perDocumentKey, 0, $iv);

        return [
            'encryptedKey'   => $encryptedKey,
            'encryptedBody'  => base64_encode($iv . $encryptedBody)
        ];
    }

    public function decryptDocument($documentHeaderObject)
    {
        $perDocumentKey = Crypt::decrypt($documentHeaderObject->encryption_key);

        // Step 2: Decode IV and encrypted body
        $encryptedBody = base64_decode($documentHeaderObject->body->encrypted_body);
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = substr($encryptedBody, 0, $ivLength);
        $encryptedBodyContent = substr($encryptedBody, $ivLength);

        // Step 3: Decrypt the body
        $decryptedBody = openssl_decrypt($encryptedBodyContent, $this->cipher, $perDocumentKey, 0, $iv);

        // Step 4: Verify checksum
        if ($this->checksum($encryptedBodyContent) !== $documentHeaderObject->body->checksum) {
            throw new \Exception('Integrity check failed!');
        }

        return $decryptedBody;
    }

    public function checksum($data)
    {
        return hash('sha256', $data);
    }
}