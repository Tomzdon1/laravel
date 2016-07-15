<?php namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Partner extends Eloquent 
{
    /**
     * Validators of model atributes
     *
     * @var array
     */
    public static $validators = [
        //
    ];

    public function guest()
    {
        return !$this->exists;
    }
}
