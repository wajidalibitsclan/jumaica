<?php

namespace Modules\User\Models;

use App\User;
use Illuminate\Support\Facades\Mail;
use Modules\Booking\Models\Payment;
use Modules\User\Emails\CreditPaymentEmail;
use Modules\User\Emails\PlanPaymentEmail;

class PlanPayment extends Payment
{

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'object_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'create_user');
    }


}
