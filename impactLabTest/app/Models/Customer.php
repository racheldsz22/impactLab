<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'phone',
        'shipping_address',
        'billing_address',
      
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Each customer belongs to one user
    }
}
