<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function sub_categories()
    {
        return $this->hasMany(\App\ExpenseCategory::class, 'parent_id');
    }

    public function scopeOnlyParent($query)
    {
        return $query->whereNull('parent_id');
    }
}
