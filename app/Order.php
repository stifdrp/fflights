<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUS = [
        'E' => 'Em elaboração',
        'P' => 'Para aprovação',
        'C' => 'Para compras',
        'A' => 'Em andamento',
        'M' => 'Emitido',
        'F' => 'Finalizado'
    ];

    public function getStatusAttribute()
    {
        return self::STATUS[ $this->attributes['status'] ];
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function budget()
    {
        return $this->belongsTo('App\Budget');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
