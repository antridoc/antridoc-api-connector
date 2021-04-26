<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        "name",
        "gender",
        "address",
        "phone_number",
        "specialist",
        "photo",
        "hospitalId",
        "created_at",
        "updated_at"
    ];

    protected $table = "doctor";
}
