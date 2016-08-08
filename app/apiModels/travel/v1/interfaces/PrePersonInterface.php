<?php

namespace App\apiModels\travel\v1\interfaces;

interface PrePersonInterface
{
    public function setBirthDate($birth_date);
    public function getBirthDate();
}