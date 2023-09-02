<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prescription_id', 'drug_name', 'drug_quantity', 'drug_amount', 'user_id', 'status',
    ];
}
