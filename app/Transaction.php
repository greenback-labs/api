<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Account;
use App\Category;
use App\Installment;
use App\Person;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_tbl';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'account_id',
        'category_id',
        'person_id',
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
        'category_id',
        'person_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the account record that owns the transaction record.
     */
    public function recordAccount()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * Get the category record that owns the transaction record.
     */
    public function recordCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the person record that owns the transaction record.
     */
    public function recordPerson()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * Get the installment records for the transaction record.
     */
    public function recordsInstallment()
    {
        return $this->hasMany(Installment::class, 'transaction_id');
    }
}
