<?php

namespace Modules\Motors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Modules\Motors\Database\Factories\MotorFactory;

class Motor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['VIN'];

    // protected static function newFactory(): MotorFactory
    // {
    //     // return MotorFactory::new();
    // }
}
