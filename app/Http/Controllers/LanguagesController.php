<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageValidation;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    // show all languges that youhave in your site

    public function IndexLanguage()
    {
        $Languages = Language::paginate(PaginationCount);
        return view('admin.languages.index', compact('Languages'));
    }
    public function CreateLanguage()
    {
        #craeate language form
        return view('admin.languages.create');
    }
    public function StoreLanguage(LanguageValidation $request)
    {
        $data = $request->all();
        // user try and catch to handel the errors
        try {

            if ($request->isMethod('post')) {
                if (empty($data['active'])) {
                    $status = 0;
                } else {
                    $status = 1;
                }
                if (is_numeric($data['name']) || is_numeric($data['abbr'])) {
                    return redirect()->back()->with('error')->with('error', "هناك خطا بادخال الاسم او الاختصار يرجى التاكد ");;
                }

                $storeData = new Language();
                $storeData->name = $data['name'];
                $storeData->abbr = $data['abbr'];
                $storeData->direction = $data['direction'];
                $storeData->active = $status;
                $storeData->save();

                return redirect()->route('show_Languages')->with('success', "تم الحفظ بنجاح");
            } else {
                return redirect()->back()->with('error', "هناك خطا ما يرجى المحاولة لاحقا");
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', "هناك خطا ما يرجى المحاولة لاحقا");
        }
    }

    // eidt the language
    public function EditLanguage($id)
    {
        $Current_info_language = Language::where('id', $id)->first();
        return view('admin.languages.edit', compact('Current_info_language'));
    }


    public function UpdateLanguage(LanguageValidation $request, $id)
    {

        $data = $request->all();
        if ($request->isMethod('post')) {
            if (empty($data['active'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            if (is_numeric($data['name']) || is_numeric($data['abbr'])) {
                return redirect()->back()->with('error')->with('error', "هناك خطا بادخال الاسم او الاختصار يرجى التاكد ");;
            }
            Language::where('id', $id)->update([
                'name' => $data['name'],
                'abbr' => $data['abbr'],
                'direction' => $data['direction'],
                'active' => $status,
            ]);
            return redirect()->route('show_Languages')->with('success', "تم التعديل بنجاح");
        }
    }
    // delete language
    public function DeleteLanguage($id)
    {
        $lanaguge = Language::find($id);
        if (!$lanaguge) {
            return redirect()->back()->with('error', 'هذه اللغة غير موجوده');
        } else {
            Language::where('id', $id)->delete();
            return redirect()->route('show_Languages')->with('success', 'تم الحذف بنجاح');
        }
    }
}
