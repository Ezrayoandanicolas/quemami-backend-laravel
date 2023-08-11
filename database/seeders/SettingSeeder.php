<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Logo Mini', 'Logo Large', 'Logo Title', 'Menu 1', 'Menu 2', 'Menu 3', 'Menu Deskripsi 1', 'Menu Deskripsi 2', 'Menu Deskripsi 3', 'Menu Image 1', 'Menu Image 2', 'Menu Image 3', 'Maps', 'Instagram', 'Whatsapp'];
        $category = ['logo_mini', 'logo_large', 'logo_title', 'menu_1', 'menu_2', 'menu_3', 'menu_1', 'menu_2', 'menu_3', 'menu_1', 'menu_2', 'menu_3', 'maps', 'instagram', 'whatsapp'];
        $n = 0;

        foreach ($name as $key => $item) {
            $setting = new Setting();
            $setting->id = $n+1;
            $setting->name = $item;
            $setting->category = $category[$n];
            $setting->value = 'Value';
            $setting->save();

            $n++;
        }
    }
}
