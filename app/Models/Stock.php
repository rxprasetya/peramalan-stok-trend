<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = ['id', 'itemID', 'stockDate', 'stockOpening', 'stockClosing', 'qtySold', 'qtyPurchased'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function item(){
        // lokasi, foreign(relation table), primary key(main table)
        return $this->belongsTo('App\Models\Item', 'itemID', 'id');
    }

}
