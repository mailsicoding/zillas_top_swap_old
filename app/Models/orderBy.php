<?php

namespace App\Models;

use App\Models\Offers\Offers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderBy extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'offer_id',
        'price'
    ];

    public function user_order()
    {
        return $this->hasMany(User::class);
    }
    public function offer_order()
    {
        return $this->hasMany(Offers::class);
    }
}
