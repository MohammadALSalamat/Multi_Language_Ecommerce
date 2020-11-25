<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Requests\VendorsValidation;

class VendorController extends Controller
{
    // Vendors code

    public function IndexVendors()
    {
        # show the vendors

        $vendors = Vendor::with('category')->get();
        return view('admin.vendors.index', compact('vendors'));
    }


    public function CreateVendors()
    {
        #show the create file tto create vendors
        $translation_lang = config('app.locale');
        $categories = MainCategory::where(['translation_lang' => $translation_lang, 'active' => 1])->get();
        return view('admin.vendors.create', compact('categories'));
    }

    public function StoreVendors(VendorsValidation $request)
    {
        # store data that come from Vendor form

        $data = $request->all();
        $data['address'] = 'Not Avalibale';
        $password = md5($data['password']);
        if (empty($data['active'])) {
            $status = 0;
        } else {
            $status = 1;
        }
        // insert logo
        if ($request->hasFile('logo')) {
            $photo_tmp = $request->file('logo');
            if ($photo_tmp->isValid()) {
                $extention = $photo_tmp->clientExtension();
                $filename = rand(1, 10000000000000) . '.' . $extention;
                $path_image = 'assets/images/vendors/' . $filename;
                Image::make($photo_tmp)->save($path_image);
            } else {
                return redirect()->back()->with('error', 'الصورة غير صحيحة الرجاء المحاولة لاحقا');
            }
        } else {
            return redirect()->back()->with('error', 'الصورة غير صحيحة الرجاء المحاولة لاحقا');
        }

        // insert the data

        $vendors = new Vendor();
        $vendors->name = $data['name'];
        $vendors->password = $password;
        $vendors->address = $data['address'];
        $vendors->category_id = $data['category_id'];
        $vendors->mobile = $data['mobile'];
        $vendors->active = $status;
        $vendors->logo = $filename;
        $vendors->save();

        return redirect()->route('show_Vendors')->with('error', 'تم اضافة المتجر بنجاح');
    }
}
