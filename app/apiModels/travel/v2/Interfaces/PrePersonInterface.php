<?php

namespace App\apiModels\travel\v2\Interfaces;

interface PrePersonInterface
{
    public function setBirthDate($birth_date);
    public function getBirthDate();
}