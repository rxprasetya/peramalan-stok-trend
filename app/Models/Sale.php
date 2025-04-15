<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = ['id', 'itemID', 'saleDate', 'qtySold', 'sale', 'totalSold'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function item(){
        // lokasi, foreign(relation table), primary key(main table)
        return $this->belongsTo('App\Models\Item', 'itemID', 'id');
    }
}
