<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{

    protected $fillable = [
        'name',
        // Add other fillable fields here if needed
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
