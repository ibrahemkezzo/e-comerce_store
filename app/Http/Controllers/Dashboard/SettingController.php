<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SettingUpdateRequest;
use App\Http\Requests\Dashboard\UpdateSettingRequest;
use App\Models\Setting;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;


class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.settings.index');
    }


    public function update(SettingUpdateRequest $request, Setting $setting)
    {

        // dd($request->validated());
        $oldData = Setting::first();
        $data = $request->except(['logo','favicon']);
        if($request->hasFile('logo')){
            $data['logo'] = ImageUpload::uploadImage($request->logo,path:'setting',oldImage:$oldData->logo);
        }
        if($request->hasFile('favicon')){
            $data['favicon'] = ImageUpload::uploadImage($request->favicon,path:'setting',oldImage:$oldData->favicon);
        }
        $setting->update($data);
    return redirect()->route('dashboard.settings.index')->with('success', 'تم تحديث الاعدادات بنجاح');

    }
}
