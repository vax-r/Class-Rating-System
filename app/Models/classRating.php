<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classRating extends Model
{
    use HasFactory;
    protected $table = "classRating";

    protected $fillable = [
        "class_id",
        "commenter",
        "rating",
        "comment",
    ];

    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
