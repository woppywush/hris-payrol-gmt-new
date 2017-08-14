<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrRapelGaji extends Model
{
    protected $table = 'pr_rapel_gaji';

    protected $fillable = ['id_histori','tanggal_proses','flag_processed'];

    public function FunctionName($value='')
    {
      return $this->belongsTo('App\Models\PrHistoriGajiPokokPerClient', 'id_histori');
    }
}
