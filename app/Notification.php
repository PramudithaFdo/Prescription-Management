<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use Notifiable;

    // Other model code...
    protected $fillable = [
        'read_at',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
