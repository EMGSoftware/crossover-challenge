<?php

use Illuminate\Database\Seeder;

class ReportTestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ReportTest::class, 25)->create();
    }
}
