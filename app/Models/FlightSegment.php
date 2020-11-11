<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightSegment extends Model
{
    protected $guarded = [];
    
    public function ticket()
    {
        return $this->belongsTo('App\Models\ticket');
    }
}
