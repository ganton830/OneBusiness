<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stxfrdetail extends Model
{
    public $timestamps = false;
    protected $table = "s_txfr_detail";
    protected $primaryKey = "Txfr_ID";
    protected $connection = 'mysql2';

    protected $fillable = [
        'item_id', 'ItemCode', 'Qty',
        'Bal', 'Movement_ID'];
}
