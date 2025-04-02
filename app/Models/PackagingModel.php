<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagingModel extends Model
{
    protected $table = 'packaging';

    protected $fillable = [
        'user_id',
        'course_id',
        'level',
        'semester',
        'category_id',
        'remarks'
    ];

    public function course()
{
    return $this->belongsTo(CoursesModel::class, 'course_id', 'id');
}

public function category()
{
    return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
}

}

