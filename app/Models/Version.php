<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Version extends Model
{
    use SoftDeletes;
    protected $fillable = ['document_id', 'version_number', 'changes_summary'];

    protected $casts = [
        'changes_summary' => 'array',
    ];

    public function document()
    {
        return $this->belongsTo(DocumentHeader::class , 'document_id');
    }
}
