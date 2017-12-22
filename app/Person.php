<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;

class Person extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'person_tbl';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
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
        'person_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the person record that owns the person record.
     */
    public function recordPerson()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * Get the transaction records for the person record.
     */
    public function recordsTransaction()
    {
        return $this->hasMany(Transaction::class, 'person_id');
    }
}
