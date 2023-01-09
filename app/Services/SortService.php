<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class SortService
{

    public function __construct()
    {
    }

    public function sort($query, $sorts){

        foreach ($sorts as $key => $sort) {
           if($sort)  $query->orderBy($key, strtoupper($sort));
        }
        return $query;
    }

}
