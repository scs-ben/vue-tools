<?php

use Illuminate\Database\Seeder;

class ExamplesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Example::class, 50)->create()->each(function($u) {
            $u->make();
        });
    }
}