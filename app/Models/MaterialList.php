<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialList extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class ,'product_id', 'id');
    }
    public function unit()
    {
        return $this->belongsTo(unit::class ,'unit', 'id');
    }
    public function myUnitName()
    {
        return $this->belongsTo(unit::class ,'unit', 'id');
    }
}
