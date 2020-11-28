<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateVendorsValidation;
use App\Models\Vendor;
use App\Models\MainCategory;
use Intervention\Image\Facades\Image;
use App\Http\Requests\VendorsValidation;
use App\Notifications\vendorCreated;
use Illuminate\Support\Facades\Notification;

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
        $vendors->email = $data['email'];
        $vendors->active = $status;
        $vendors->logo = $filename;
        $vendors->save();

        Notification::send($vendors, new vendorCreated($vendors));
        return redirect()->route('show_Vendors')->with('error', 'تم اضافة المتجر بنجاح');
    }

    public function EditVendors($id)
    {
        $Check_id = Vendor::find($id);
        if (!$Check_id) {
            return redirect()->back()->with('error', 'هذا القسم غير موجوده');
        }
        $translation_lang = config('app.locale');
        #edit vendor file
        $vendor = Vendor::with('category')->where('id', $id)->first();
        $categories = MainCategory::where(['translation_lang' => $translation_lang, 'active' => 1])->get();

        return view('admin.vendors.edit', compact('vendor', 'categories'));
    }

    public function UpdateVendors(UpdateVendorsValidation $request, $id)
    {
        $Check_id = Vendor::find($id);
        if (!$Check_id) {
            return redirect()->back()->with('error', 'هذا القسم غير موجوده');
        }
        #upadte the vendors
        $data = $request->all();
        // validation logo
        if (!empty($data['logo'])) {
            if ($request->hasFile('logo')) {
                $logo_temp = $request->file('logo');
                if ($logo_temp->isValid()) {
                    $extention = $logo_temp->clientExtension();
                    $filename = rand(1, 10000000) . '.' . $extention;
                    $image_path = 'assets/images/vendors/' . $filename;
                    Image::make($logo_temp)->save($image_path);
                }
            } else {
                return redirect()->back()->with('error', "الصورة خاطئة اعد المحاولة");
            }
        } else {
            $filename = $data['current_logo'];
        }

        // validation other inputs

        if (empty($data['name']) || empty($data['mobile']) || empty($data['email'])) {
            return  redirect()->back()->with('error', 'كافة الحقول مطلوبة الرجاء ملئ جميع الحقول');
        }
        if (empty($data['active'])) {
            $status = 0;
        } else {
            $status = 1;
        }

        Vendor::where('id', $id)->update([
            'logo' => $filename,
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'address' => $data['address'],
            'active' => $status,
        ]);
        return redirect()->route('show_Vendors')->with('success', "تم التعديل بنجاح");
    }

    // direcate activate
    public function Directe_Activate($id)
    {
        $active = Vendor::where('id', $id)->first();

        if ($active->active == 1) {

            Vendor::where('id', $id)->update([
                'active' => 0
            ]);
            return redirect()->route('show_Vendors')->with('success', "تم الغاء التفغيل بنجاح");
        } else {
            Vendor::where('id', $id)->update([
                'active' => 1
            ]);
            return redirect()->route('show_Vendors')->with('success', "تم  التفغيل بنجاح");
        };
    }

    // delete vendors
    public function DeleteVendors($id)
    {
        $Delet_category = Vendor::find($id);
        if (!$Delet_category) {
            return redirect()->back()->with('error', 'هذا القسم غير موجوده');
        }
        Vendor::where('id', $id)->delete();
        return redirect()->route('show_Vendors')->with('success', 'تم الحذف بنجاح');
    }
}
