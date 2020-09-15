<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
