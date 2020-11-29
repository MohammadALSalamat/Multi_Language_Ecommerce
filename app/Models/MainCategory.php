<?php

namespace App\Models;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainCategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = "main_categories";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'translation_lang',
        'translation_of',
        'name',
        'slug',
        'photo',
        'active',
        'created_at',
        'updated_at',
    ];

    // make scope to call active product when it is == 1

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    //relation in same table with other column
    public function OtherLanguges()
    {
        return $this->hasMany(self::class, 'translation_of');
    }

    // relation with subcategory
    public function subcategory()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }

    // relation with vendors table
    public function vendors()
    {
        return $this->hasMany("App\Models\Vendor", 'category_id', 'id');
    }
}
