<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    public function auditrail()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
