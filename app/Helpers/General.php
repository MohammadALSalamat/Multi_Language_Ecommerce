<?php
// languages Section

use App\Models\Language;
use Illuminate\Support\Facades\Config;

function get_languages()
{
    # select the active languages from language table
    return  Language::where('active', 1)->get();
}


// get defualt language from configration
function defualt_lang()
{
    return Config::get('app.locale');
}
