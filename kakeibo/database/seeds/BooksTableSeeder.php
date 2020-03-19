<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'family_number' => 1,
            'budget' => '支出',
            'money' => 1000,
            'memo' => 'aaaaaaaaaaaaaaaaaaaaaaaaa',
            'days' => '2020-03-01',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('books')->insert([
            'family_number' => 1,
            'budget' => '収入',
            'money' => 10000,
            'memo' => 'aaaaaaaaaaaaaaaaaaaaaaaaa',
            'days' => '2020-03-11',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('books')->insert([
            'family_number' => 2,
            'budget' => '支出',
            'money' => 500,
            'memo' => 'iiiiiiiiiiiiiiiiiiiiiiiiii',
            'days' => '2020-03-05',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('books')->insert([
            'family_number' => 3,
            'budget' => '支出',
            'money' => 800,
            'memo' => 'uuuuuuuuuuuuuuuuuuuuuuuuuuu',
            'days' => '2020-03-12',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
