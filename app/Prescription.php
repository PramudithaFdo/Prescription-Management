<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'note', 'delivery_address', 'delivery_time', 'prescription_file', 'user_id',
    ];
}
