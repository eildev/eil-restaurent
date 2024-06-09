<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function makeItems()
    {
        return $this->belongsTo(MakeItem::class ,'item_id', 'id');
    }

    public function menuItems()
    {
        return $this->belongsTo(SetMenu::class, 'menu_id','id');
    }

}
