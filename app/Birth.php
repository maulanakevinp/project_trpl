<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Birth extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','gender','birth_place','birth_date','religion','address','order','name_parent','age','gender_parent','job','address_parent', 'user_id', 'letter_id','file'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function letter()
    {
        return $this->belongsTo('App\Letter');
    }
}
