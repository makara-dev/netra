<?php

namespace App\CustomLibs;

trait ArrayCompare
{
    /**
     * compare array by value pairs, 
     * @return true if value match no matter the order of element
     * @see WARNING : DO NOT REUSE THIS, IT DOES NOT WORK IN SOME CASES
     * @see WRONG_CASE : $a = [1, 2, 2] , $b = [1, 1, 2]
     */
    public static function array_equals(array $a, array $b)
    {
        return (is_array($a)
            && is_array($b)
            && count($a) == count($b)
            && array_diff($a, $b) === []);
    }
}
