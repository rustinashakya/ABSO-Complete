<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = SiteSetting::create([
            'title' => "A big shout out",
            'email'=> null,
            'phone_no' => null,
            'email' => null,
            'facebook' => null,
            // 'youtube' => null,
            'instagram' => null,
            'meta_keyword' => null,
            'meta_description' => null,
            'language_id'=> 1,
        ]);

    }
}
