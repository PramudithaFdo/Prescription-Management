<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'prescription_photos';

    protected $fillable = ['prescription_Id', 'filename'];
}
