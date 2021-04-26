<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        "name",
        "phone_number",
        "address_line_1",
        "address_line_2",
        "province",
        "regency",
        "longitude",
        "latitude",
        "zip",
        "description",
        "photo",
        "ownerId",
        "web_app_tag",
        "created_at",
        "updated_at"
    ];

    protected $table = "hospital";

    public function User() {
        return $this->belongsTo(User::class, "ownerId");
    }
}
