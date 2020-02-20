<?php

use Illuminate\Database\Seeder;

class BVCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\BVCriteria::truncate();
        $now = now()->toDateTimeString();
        \App\BVCriteria::insert([
            ['title' => 'Basic',   'percentage' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Silver',  'percentage' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Gold',    'percentage' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Diamond', 'percentage' => 15, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
