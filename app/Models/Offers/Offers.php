<?php

namespace App\Models\Offers;

use App\Models\method;
use App\Models\orderBy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'price',
        'offer_type',
        'status',
        'payment_method',
        'match_user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function offer_methods()
    {
        return $this->belongsToMany(method::class, 'offers_methods', 'offer_id', 'method_id');
    }
    public function order_offers()
    {
        return $this->belongsTo(orderBy::class, 'offer_id', 'id');
    }
}
