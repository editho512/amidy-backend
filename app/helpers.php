<?php

if(!function_exists('generateFourNumberMin')){
    function generateFourNumberMin($number){
        if (strlen($number) < 4) {
            for ($i = strlen($number); $i < 4; $i++) {
                $number = 0 . $number;
            }
        }
        return $number;
    }
}
