<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterClient extends Model
{
    protected $table = 'master_client';

    protected $fillable = ['kode_client','nama_client','token'];
    
}
