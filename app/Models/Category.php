<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_name',
    ];



    function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}