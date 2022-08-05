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
        'match_user_id',
        'price',
        'status',
        'method'
    ];

    public function user_order()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function offer_order()
    {
        return $this->belongsTo(Offers::class, 'offer_id');
    }
}
