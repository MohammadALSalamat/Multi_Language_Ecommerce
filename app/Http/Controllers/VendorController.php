<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Http\Requests\VendorsValidation;

class VendorController extends Controller
{
    // Vendors code

    public function IndexVendors()
    {
        # show the vendors

        $vendors = Vendor::get();
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


    }
}
