<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class DashboardController extends Controller
{
    public function index()
    {
        $setting = Setting::all();

        foreach ($setting as $key => $value) {
            switch ($value->name) {
                case 'Logo Mini':
                        $value->imageUrl = URL::to('/').'/settings/'.$value->value;
                        $logoMini = $value;
                    break;
                case 'Logo Large':
                        $value->imageUrl = URL::to('/').'/settings/'.$value->value;
                        $logoLarge = $value;
                    break;
                case 'Logo Title':
                        $logoTitle = $value;
                    break;
                case 'Menu 1':
                        $menu1 = $value;
                    break;
                case 'Menu 2':
                        $menu2 = $value;
                    break;
                case 'Menu 3':
                        $menu3 = $value;
                    break;
                case 'Menu Deskripsi 1':
                        $menu_deskripsi_1 = $value;
                    break;
                case 'Menu Deskripsi 2':
                        $menu_deskripsi_2 = $value;
                    break;
                case 'Menu Deskripsi 3':
                        $menu_deskripsi_3 = $value;
                    break;
                case 'Menu Image 1':
                        $value->imageUrl = URL::to('/').'/settings/'.$value->value;
                        $menu_image_1 = $value;
                    break;
                case 'Menu Image 2':
                        $value->imageUrl = URL::to('/').'/settings/'.$value->value;
                        $menu_image_2 = $value;
                    break;
                case 'Menu Image 3':
                        $value->imageUrl = URL::to('/').'/settings/'.$value->value;
                        $menu_image_3 = $value;
                    break;

                default:
                    # code...
                    break;
            }
        }

        $response = [
            'logo_mini' => $logoMini,
            'logo_large' => $logoLarge,
            'logo_title' => $logoTitle,
            'menu_1' => $menu1,
            'menu_2' => $menu2,
            'menu_3' => $menu3,
            'menu_deskripsi_1' => $menu_deskripsi_1,
            'menu_deskripsi_2' => $menu_deskripsi_2,
            'menu_deskripsi_3' => $menu_deskripsi_3,
            'menu_image_1' => $menu_image_1,
            'menu_image_2' => $menu_image_2,
            'menu_image_3' => $menu_image_3,
        ];

        return response()->json($response, 200);
    }
}
