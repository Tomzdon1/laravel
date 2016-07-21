<?php namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Quote extends Eloquent 
{
	 /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Validators of model atributes
     *
     * @var array
     */
    public static $validators = [
        //
    ];
}
