<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'letter_id', 'salary', 'reason', 'verify1', 'verify2'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function letter()
    {
        return $this->belongsTo('App\Letter');
    }
}
