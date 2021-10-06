<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_works()
    {
        $this->assertTrue(true);
        //Test code
    }

    /** @test */
    public function it_fails()
    {
        $this->assertTrue(true);
        $this->assertFalse(false);
    }


    /** @test */
    public function another_test()
    {
        $this->assertTrue(true);
        $this->assertFalse(false);
    }


}
