<?php

namespace App\Demo;

class FizzBuzz
{
    public function process($collection)
    {
        $filtered_collection = array_filter($collection, function($item) {
            if (is_int($item)) {
                return true;
            }
            return false;
        });

        if ($filtered_collection !== $collection) {
            throw new \Exception("Did not receive collection of integers");
        }

        return $filtered_collection;

    }
}
