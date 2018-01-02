<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;

class Account extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account_tbl';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'account_id',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'account_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the account record that owns the account record.
     */
    public function recordAccount()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * Get the account records for the account record.
     */
    public function recordsAccount()
    {
        return $this->hasMany(Account::class, 'account_id');
    }

    /**
     * Get the account records for the account record, recursively.
     */
    public function recordsAccountRecursive()
    {
        return $this->recordsAccount()->with('recordsAccountRecursive');
    }

    /**
     * Get the transaction records for the account record.
     */
    public function recordsTransaction()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }
}
