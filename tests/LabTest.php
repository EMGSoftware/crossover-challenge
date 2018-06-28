<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LabTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testLab()
    {
        // Verify the Login page
        $this->visit('/')
             ->see('Lab @ Crossover');
        
        // Verify the DB connection is OK and there is an Admin user
        $this->seeInDatabase('users', ['email' => 'admin@crossover.com']);
        
        // Verify the login process
        $this->visit('/')
             ->select('admin@crossover.com', 'email')
             ->type('123456', 'password')
             ->press('Login')
             ->seePageIs ('https://localhost/reports');
    }
}
