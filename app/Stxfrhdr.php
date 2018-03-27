<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stxfrhdr extends Model
{
    public $timestamps = false;
    protected $table = "s_txfr_hdr";
    protected $primaryKey = "Txfr_ID";
    protected $connection = 'mysql2';

    protected $fillable = [
        'Txfr_Date', 'Txfr_To_Branch', 'Rcvd',
        'DateRcvd', 'Shift_ID','Uploaded'];
    
}
