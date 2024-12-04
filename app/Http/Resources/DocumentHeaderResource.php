<?php

namespace App\Http\Resources;

use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentHeaderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'module'    => $this->module,
            'version'   => $this->version,
            'owner'     => $this->owner->name,
            'body'      => (new EncryptionService)->decryptDocument($this),
        ];
    }
}
