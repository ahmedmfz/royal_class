<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentBody extends Model
{
    use SoftDeletes;
    protected $fillable = ['document_id', 'body', 'checksum'];

    public function header()
    {
        return $this->belongsTo(DocumentHeader::class , 'document_id' , 'id');
    }
}
