<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DataCreatorUpdator;

class PaymentMethod extends Model
{
    use DataCreatorUpdator;

    protected $guarded = ['id'];
    protected $casts = [ 'created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s' ];
    protected $table = 'payment_method';
}
