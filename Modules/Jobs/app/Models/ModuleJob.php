<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Modules\Jobs\Database\Factories\JobFactory;

class ModuleJob extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['salary_min' , 'salary_max'];

    // protected static function newFactory(): JobFactory
    // {
    //     // return JobFactory::new();
    // }
}
