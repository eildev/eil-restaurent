<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function makeItem()
    {
        return $this->belongsTo(MaterialList::class ,'id', 'make_item_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
