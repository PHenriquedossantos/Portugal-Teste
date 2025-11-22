<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = ['person_id', 'country_code', 'number'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
