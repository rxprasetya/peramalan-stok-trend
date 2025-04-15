<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opname extends Model
{
    use HasFactory;

    protected $table = 'opnames';

    protected $fillable = ['id', 'itemID', 'opnameDate', 'systemStock', 'physicalStock', 'difference', 'remarks'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function item(){
        // lokasi, foreign(relation table), primary key(main table)
        return $this->belongsTo('App\Models\Item', 'itemID', 'id');
    }
}
