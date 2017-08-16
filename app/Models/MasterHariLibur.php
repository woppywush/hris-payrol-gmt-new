<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterHariLibur extends Model
{
    protected $table = 'master_hari_libur';

    protected $fillable = ['libur','keterangan','status'];
}
