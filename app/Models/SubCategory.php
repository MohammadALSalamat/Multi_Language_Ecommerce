<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\MainCategory;

class SubCategory extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'translation_lang',
        'translation_of',
        'name',
        'parent_id',
        'slug',
        'photo',
        'active',
        'created_at',
        'updated_at',
    ];

    // relation with MainCategory
    public function maincategory()
    {
        return $this->belongsTo(MainCategory::class, 'category_id', 'id');
    }
}
