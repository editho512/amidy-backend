<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class PaginationService {

    private $options = [
        "totalPages" => null,
        "total" => null,
        "perPage" => 5,
        "currentPage" => 1,
        "hasMorePages" => true
    ];

    public function __construct()
    {

    }

    private function skipRow(){
        return ($this->options["currentPage"] - 1 ) * $this->options['perPage'];
    }

    private function setTotal($model){
        $this->options['total'] = $model->count();
        $this->options['totalPages'] = ceil($this->options['total'] / $this->options['perPage']);
    }

    public function paginate($model , $option = []){
        if(isset($option['page'])) $this->options["currentPage"] = intval($option['page']);

        //fetch the total row
        $this->setTotal($model);

        //get nomber of skipped row
        $skipped = $this->skipRow();

        //update the current page
        $response = $model->when($skipped > 0, function($query) use ($skipped){
            return $query->skip($skipped);

        })->take($this->options['perPage']);

        return $response;
    }

    public function getOptions(){
        return $this->options;
    }

}
