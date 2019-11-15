<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductResponse extends Model
{
    protected $table = "tr_product_response";
    public function product()
    {
        return $this->belongsTo('App\Product')->withDefault();
    }
}
