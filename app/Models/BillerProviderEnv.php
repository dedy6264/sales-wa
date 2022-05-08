<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DataCreatorUpdator;

class BillerProviderEnv extends Model
{
    use DataCreatorUpdator;

    //
    protected $table = 'provider_payment_env';
    protected $casts = [ 'created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s' ];
    protected $guarded = ['id'];
}
