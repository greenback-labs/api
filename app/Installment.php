<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;

class Installment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'installment_tbl';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'transaction_id',
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
        'transaction_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the transaction record that owns the installment record.
     */
    public function recordTransaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
