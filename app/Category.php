<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_tbl';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'category_id',
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
        'category_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the category record that owns the category record.
     */
    public function recordCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the category records for the category record.
     */
    public function recordsCategory()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    /**
     * Get the transaction records for the category record.
     */
    public function recordsTransaction()
    {
        return $this->hasMany(Transaction::class, 'category_id');
    }
}
