<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classInfo extends Model
{
    use HasFactory;

    protected $table = "classInfo";
    
    protected $fillable = [
        "class_id",
        "class_name",
        "teacher",
        "credit",
        "Required",
        "outline",
        "rating",
    ];

    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
