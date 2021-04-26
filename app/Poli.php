<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $fillable = [
        "name",
        "hospitalId",
        "created_at",
        "updated_at"
    ];

    protected $table = "poli";
}
