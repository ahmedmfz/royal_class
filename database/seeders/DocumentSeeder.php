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
            'module'     => "General",
            'metadata'   => [],
            'body'       => fake()->text(),
        ]);
    }

}

