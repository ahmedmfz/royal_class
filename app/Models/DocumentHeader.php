<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentHeader extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'module', 'version', 'metadata', 'encryption_key'];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function bodies()
    {
        return $this->hasMany(DocumentBody::class , 'document_id' , 'id');
    }

    public function body()
    {
        return $this->hasOne(DocumentBody::class , 'document_id' , 'id');
    }

    public function versions()
    {
        return $this->hasMany(Version::class, 'document_id' , 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
