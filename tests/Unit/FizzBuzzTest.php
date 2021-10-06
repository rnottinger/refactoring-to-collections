<?php

namespace Tests\Unit;

use App\Demo\FizzBuzz;
use Exception;

class FizzBuzzTest extends \PHPUnit\Framework\TestCase
{

    /**
     * FizzBuzz
     * covers iterating over collections, loops, and conditional statements
     * • you have a list of positive integers
     * • you iterate through the list, examining each item
     * • if the integer is divisible by 3, you return ‘Fizz’
     * • if the integer is divisible by 5, you return ‘Buzz’
     * • if the integer is divisible by both 3 and 5, you return ‘FizzBuzz’
     * • otherwise just return the integer
     *
     * let’s start with writing a test
     * which assumes the code is already working.
     */

    /**
     * @test
     *
     * @throws \Exception
     */
    function handlesNonIntegersInCorrectly()
    {
        $this->expectException(Exception::class);
        $fizzBuzz = new FizzBuzz();
        $collection = ['A',1,'B','C',1.234];
        $fizzBuzz->process($collection);
    }


    /**
     * @test
     *
     * @throws \Exception
     */
    function handlesFizzCorrectly()
    {
        $fizzBuzz = new FizzBuzz();
        $collection = [1,2,3,4,6,7,9];
        $expected = [1,2,'Fizz',4,'Fizz',7,'Fizz'];
        $actual = $fizzBuzz->process($collection);
        $this->assertEquals(
            $expected,
            $actual,
            "FizzBuzz did correctly find Fizz values"
        );
    }

}
