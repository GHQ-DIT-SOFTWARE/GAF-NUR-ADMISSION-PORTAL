<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    //
    protected $table = 'category';

    protected $fillable = [
        'user_id',
        'category_id',
        'category_name',
        'credit_hours',
        'level',
        'category_remarks'
    ];
}
