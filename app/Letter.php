<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'verify1', 'verify1', 'reason1', 'reason2', 'created_at', 'updated_at'
    ];

    public function salaries()
    {
        return $this->hasMany('App\Salary');
    }

    public function incapables()
    {
        return $this->hasMany('App\Incapable');
    }
}
