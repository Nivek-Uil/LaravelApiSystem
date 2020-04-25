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
            'nickname' => '开发人员',
            'avatar' => 'http://xyeadmin.hzsw-tech.com/storage/assets/icon.png',
            'created_at' => now()
        ];
        for ($i = 1; $i < 10; $i++) {
            $data[$i]['account'] = strtolower(Str::random(5));
            $data[$i]['password'] =  bcrypt('123456');
            $data[$i]['nickname'] =  Str::random(5);
            $data[$i]['avatar'] =  'http://xyeadmin.hzsw-tech.com/storage/assets/icon.png';
            $data[$i]['created_at'] =  now();
        }

        DB::table('users')->insert($data);

        $root = \App\Models\User::where('account','root')->first();
        $root->assignRole('root');
    }
}
