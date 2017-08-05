<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBank extends Model
{
    protected $table = 'master_bank';

    protected $fillable = ['nama_bank','flag_status'];

}
