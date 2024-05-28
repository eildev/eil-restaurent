<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Calculate balance before saving the transaction
        static::saving(function ($transaction) {
            // Assuming you want to fetch the last balance first
            $lastTransaction = self::where('account_id', $transaction->account_id)->latest()->first();
            $lastBalance = $lastTransaction ? $lastTransaction->balance : 0;

            // Update the current balance
            $transaction->balance = $lastBalance + $transaction->credit - $transaction->debit;
        });
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'account_id', 'id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
