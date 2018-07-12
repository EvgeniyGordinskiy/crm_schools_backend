<?php
namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\HasOne;

interface HasTypesInterface
{
    public function types() : HasOne;
}