<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Flight extends Eloquent {

	//protected $table = 'flights';
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}