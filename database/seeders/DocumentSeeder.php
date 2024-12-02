<?php

namespace Database\Seeders;

use App\Services\DocumentService;
use App\Services\EncryptionService;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{

    public function run(): void
    {
        $encryptedObject = new EncryptionService;
        (new DocumentService($encryptedObject))->storeDocument([
            'module'     => 1,
            'metadata'   => [],
            'body'       => 'hi every body',
        ]);
    }

}

