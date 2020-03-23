<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $data[0] = [
            'account'  => 'root',
            'password' =>  bcrypt('root'),
            'created_at' => now()
        ];
        for ($i = 1; $i < 10; $i++) {
            $data[$i]['account'] = Str::random(5);
            $data[$i]['password'] =  bcrypt('123456');
            $data[$i]['created_at'] =  now();
        }

        DB::table('users')->insert($data);
    }
}
