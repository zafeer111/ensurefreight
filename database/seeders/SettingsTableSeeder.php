<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->delete();
        $data = constants('settings.keys');
        $post = [];
        $createdAt = date('Y-m-d H:i:s');
        foreach ($data as $key => $value){
            $post[] = [
                'title' => $value['title'],
                'key' => $key,
                'value' => json_encode(''),
                'created_at' =>$createdAt
            ];
        }

        DB::table('settings')->insert($post);

    }
}
