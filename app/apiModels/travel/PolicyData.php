<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\apiModels\travel;

/**
 * Description of PolicyData
 *
 * @author dalek
 */
class PolicyData
{
    public $promo_code;
    public $start_date;
    public $end_date;
    public $abroad;
    public $family;
    public $destination;
    public $option_values;
    
    public function __construct($start_date, $end_date, $abroad, $family, $destination, $option_values, $promo_code = '')
    {
        $this->promo_code    =$promo_code;
        $this->start_date    =$start_date;
        $this->end_date      =$end_date;
        $this->abroad        =$abroad;
        $this->family        =$family;
        $this->destination   =$destination;
        $this->option_values =$option_values;
    }
    
    public function validate($param_name)
    {
        $method_name = 'validate_'.$param_name;
        if (method_exists($this, $method_name)) {
            $response = call_user_func_array(array($this, $method_name));
        } else {
            $response = false;
        }
        return $response;
    }
    
    private function validate_promo_code()
    {
        if (!empty($this->promo_code)) {
            return true;
        }
        return false;
    }
}
