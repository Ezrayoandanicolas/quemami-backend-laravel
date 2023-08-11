<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;
use File;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLogo()
    {
        try {
            $logoMini = Setting::where('category', 'logo_mini')->first();
            $logoMini->imageUrl = URL::to('/').'/settings/'.$logoMini->value;
            $logoLarge = Setting::where('category', 'logo_large')->first();
            $logoLarge->imageUrl = URL::to('/').'/settings/'.$logoLarge->value;
            $logoTitle = Setting::where('category', 'logo_title')->first();

            $response = [
                'logo_mini' => $logoMini,
                'logo_large' => $logoLarge,
                'logo_title' => $logoTitle,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }

    public function updateLogo(UpdateSettingRequest $request, $id)
    {
        $this->validate($request,[
            'imageUpload' => 'required',
        ]);

        try {
            $setting = Setting::find($id);
            $deleteImage = File::delete('settings/'.$setting->value);

            if($deleteImage) {
                $images = $request->file('imageUpload');
                $name = time().'.'.$images->getClientOriginalExtension();
                $destinationPath = public_path('/settings');
                $images->move($destinationPath, $name);

                $setting->value = $name;
                $setting->update();
            }


            $setting->imageUrl = URL::to('/').'/images/'.$setting->value;

            if($setting->category == 'logo_mini') {
                $response = [
                    'logo_mini' => $setting,
                ];
            } else {
                $response = [
                    'logo_large' => $setting,
                ];
            }
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }

    public function updateLogoTitle(UpdateSettingRequest $request, $id)
    {
        $this->validate($request,[
            'value' => 'required',
        ]);

        try {
            $setting = Setting::find($id);

            $setting->value = $request['value'];
            $setting->update();

            $response = [
                'logo_title' => $setting,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }

    public function indexMenu()
    {
        try {
            $menu1 = Setting::where('category', 'menu_1')->get();
            foreach ($menu1 as $key => $value) {
                if ($value->name == 'Menu Image 1') {
                    $value->imageUrl = URL::to('/').'/settings/'.$value->value;
                }
            }

            $menu2 = Setting::where('category', 'menu_2')->get();
            foreach ($menu2 as $key => $value) {
                if ($value->name == 'Menu Image 2') {
                    $value->imageUrl = URL::to('/').'/settings/'.$value->value;
                }
            }

            $menu3 = Setting::where('category', 'menu_3')->get();
            foreach ($menu3 as $key => $value) {
                if ($value->name == 'Menu Image 3') {
                    $value->imageUrl = URL::to('/').'/settings/'.$value->value;
                }
            }

            $response = [
                'menu_1' => $menu1,
                'menu_2' => $menu2,
                'menu_3' => $menu3,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }

    public function UpdateMenu(UpdateSettingRequest $request, $id)
    {
        $this->validate($request,[
            'imageUpload' => 'required',
        ]);

        try {
            $setting = Setting::find($id);
            $deleteImage = File::delete('settings/'.$setting->value);

            if($deleteImage) {
                $images = $request->file('imageUpload');
                $name = time().'.'.$images->getClientOriginalExtension();
                $destinationPath = public_path('/settings');
                $images->move($destinationPath, $name);

                $setting->value = $name;
                $setting->update();
            }


            $setting->imageUrl = URL::to('/').'/images/'.$setting->value;

            if($setting->category == 'menu_1') {
                $response = [
                    'menu_1' => $setting,
                ];
            } else if($setting->category == 'menu_2') {
                $response = [
                    'menu_2' => $setting,
                ];
            } else {
                $response = [
                    'menu_3' => $setting,
                ];
            }
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }

    public function updateMenuText(UpdateSettingRequest $request, $id)
    {
        $this->validate($request,[
            'value' => 'required',
        ]);

        try {
            $setting = Setting::find($id);

            $setting->value = $request['value'];
            $setting->update();

            if ($setting->name == 'Menu 1') {
                $response = [
                    'menu_1' => $setting,
                ];
            }
            if ($setting->name == 'Menu 1') {
                $response = [
                    'men_deskripsi_1' => $setting,
                ];
            }
            if ($setting->name == 'Menu 2') {
                $response = [
                    'menu_2' => $setting,
                ];
            }
            if ($setting->name == 'Menu 1') {
                $response = [
                    'men_deskripsi_2' => $setting,
                ];
            }
            if ($setting->name == 'Menu 3') {
                $response = [
                    'menu_3' => $setting,
                ];
            }
            if ($setting->name == 'Menu 3') {
                $response = [
                    'men_deskripsi_3' => $setting,
                ];
            }
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }
}
