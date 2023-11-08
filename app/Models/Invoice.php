<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'merchant_ref', 'tripay_references', 'buyer_email', 'buyer_phone', 'payment_status', 'checkout_url'
    ];

    public function product(): HasOne {
        return $this->hasOne(Product::class, 'id', 'product_id' );
    }

}
