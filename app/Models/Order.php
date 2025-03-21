<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model 
{
    use SoftDeletes;
    protected $guarded = [];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
