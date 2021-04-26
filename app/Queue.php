<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = [
        "patient_id",
        "doctor_id"
    ];
}
