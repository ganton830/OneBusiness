<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;
    protected $table = "t_cities";

    public function province()
    {
        return $this->belongsTo(\App\Province::class, "Prov_ID", "Prov_ID");
    }
}
