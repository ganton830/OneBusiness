<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Srcvdetail extends Model
{
    public $timestamps = false;
    protected $table = "s_rcv_detail";
    protected $primaryKey = "RR_No";
    protected $connection = 'mysql2';

    protected $fillable = [
        'RcvDate', 'item_id', 'ItemCode',
        'ServedQty', 'Qty' ,'Bal','Cost','Movement_ID','RMA_Qty'];
}
