<?php

namespace App\Models;

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

    public function getStatusNameAttribute()
    {
        return self::STATUS[ $this->attributes['status'] ];
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function budget()
    {
        return $this->belongsTo('App\Models\Budget');
    }

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function path()
    {
        return route('order.show', $this);
    }

    public function inElaboration()
    {
        return $this->verifyStatus('E');
    }

    public function forQuote()
    {
        return $this->verifyStatus('C');
    }

    public function inProgress()
    {
        return $this->verifyStatus('A');
    }

    protected function verifyStatus($status)
    {
        if($this->status == $status)
            return true;
        return false;
    }
}
