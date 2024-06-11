<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetMenu extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function menuItemHas()
    {
        return $this->hasMany(MakeItem::class);
    }
    // public function items()
    // {
    //     return $this->hasMany(MakeItem::class, 'menu_id');
    // }
}
