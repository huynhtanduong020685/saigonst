<?php

namespace Botble\Payment\Models;

use Botble\Base\Models\BaseModel;

class Payment extends BaseModel
{

    const METHOD_PAYPAL = 'paypal';
    const METHOD_STRIPE = 'stripe';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * @var array
     */
    protected $fillable = [
        'amount',
        'currency',
        'user_id',
        'charge_id',
        'payment_chanel',
    ];
}
