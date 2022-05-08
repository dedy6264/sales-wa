<?php 

namespace App\Traits;

trait DataCreatorUpdator
{
    protected static function bootDataCreatorUpdator()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->user()->username;
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->user()->username;
        });
    }

    public function getCreatedAtAttribute($date)
    {
        return $date != null ? date('Y-m-d H:i:s', strtotime($date)) : NULL;
    }

    public function getUpdatedAtAttribute($date)
    {
        return $date != null ? date('Y-m-d H:i:s', strtotime($date)) : NULL;
    }
}