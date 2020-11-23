<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\MainCategoryValidation;

class MainCategoryController extends Controller
{
    // show all languges that youhave in your site

    public function IndexMainCategory()
    {
        // get the config file data
        $defual_lang = defualt_lang(); // this function is from helper file shortcut function
        $categories = MainCategory::where('translation_lang', $defual_lang)->get();
        return view('admin.maincategories.index', compact('categories'));
    }
    public function CreateMainCategory()
    {
        #craeate main category form
        return view('admin.maincategories.create');
    }
    public function StoreMainCategory(MainCategoryValidation $request)
    {
        // user try and catch to handel the errors
        try {
            // make the data that comes from the create Main_categpry form a collection
            $Main_Category = collect($request->category);

            // make filtter to sperate the languages ad to get the defualt language that user selected
            $filter = $Main_Category->filter(function ($value, $key) {

                // this means when the user try to change the defualt lang from config file it will be changes here as well

                return $value['abbr'] == Config::get('app.locale');
            });


            #important Note :: if we have lots of queries need to be inserted to database then we have to use DB::commit();
            DB::beginTransaction(); // start to insert data and dont insert if there is error otherwise DB::commit

            // this query will insert the defualt languge info
            $default_Category = (array_values($filter->all()))[0];
            // save image
            if ($request->hasFile('photo')) {
                $photo_temp = $request->file('photo');
                if ($photo_temp->isValid()) {
                    $extention = $photo_temp->clientExtension();
                    $filename = rand(1, 10000000) . '.' . $extention;
                    $image_path = 'assets/images/maincategories/' . $filename;
                    Image::make($photo_temp)->save($image_path);
                }
            } else {
                return redirect()->back()->with('error', "الصورة خاطئة اعد المحاولة");
            }
            // insert the data to database and get the default language ID
            $default_Category_id = MainCategory::insertGetId([
                'translation_lang' => $default_Category['abbr'],
                'translation_of' => 0,
                'name' => $default_Category['name'],
                'slug' => $default_Category['name'],
                'photo' => $filename
            ]);
            // make filtter to sperate the languages ad to get the  languages expect defualt one that we selected

            $filter_Not_Defualt_language = $Main_Category->filter(function ($value, $key) {

                // this means when the user try to change the defualt lang from config file it will be changes here as well

                return $value['abbr'] != Config::get('app.locale');
            });
            // this query will insert all languages expect defualt language
            // make loop to fetch all languages
            if (isset($filter_Not_Defualt_language) && $filter_Not_Defualt_language->count()) {
                // create empty array to push all arries in
                $not_default_array = [];
                foreach ($filter_Not_Defualt_language as $not_default) {
                    $not_default_array[] = [
                        'translation_lang' => $not_default['abbr'],
                        'translation_of' => $default_Category_id, // id of default language
                        'name' => $not_default['name'],
                        'slug' => $not_default['name'],
                        'photo' => $filename
                    ];
                }
                //insert the data
                MainCategory::insert($not_default_array);

                return redirect()->route('show_MainCategory')->with('success', "تم الحفظ بنجاح");
            }

            DB::commit(); // commit database queries if all above are true


        } catch (\Exception $ex) {

            DB::rollBack(); // if the above database has error then dont insert anything

            return redirect()->back()->with('error', "هناك خطا ما يرجى المحاولة لاحقا");
        }
    }

    // eidt the categories
    public function EditMainCategory($id)
    {
        $Current_info_Section = MainCategory::with('OtherLanguges')->where('id', $id)->get();
        dd($Current_info_Section);
        return view('admin.maincategories.edit', compact('Current_info_Section'));
    }


    public function UpdateMainCategory(MainCategoryValidation $request, $id)
    {

        $data = $request->all();
        dd($data);
        if ($request->isMethod('post')) {
            if (empty($data['active'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            if (is_numeric($data['name']) || is_numeric($data['abbr'])) {
                return redirect()->back()->with('error')->with('error', "هناك خطا بادخال الاسم او الاختصار يرجى التاكد ");;
            }
            MainCategory::where('id', $id)->update([
                'name' => $data['name'],
                'abbr' => $data['abbr'],
                'direction' => $data['direction'],
                'active' => $status,
            ]);
            return redirect()->route('show_Languages')->with('success', "تم التعديل بنجاح");
        }
    }
    // delete main caregory
    public function DeleteLanguage($id)
    {
        $lanaguge = MainCategory::find($id);
        if (!$lanaguge) {
            return redirect()->back()->with('error', 'هذه اللغة غير موجوده');
        } else {
            MainCategory::where('id', $id)->delete();
            return redirect()->route('show_Languages')->with('success', 'تم الحذف بنجاح');
        }
    }
}
