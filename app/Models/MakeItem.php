<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function makeItemlist()
    {
        return $this->belongsTo(MaterialList::class ,'id', 'make_item_id');
    }

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'make_category_id','id');
    }
    public function makeItem()
    {
        return $this->hasMany(MaterialList::class);
    }


}
