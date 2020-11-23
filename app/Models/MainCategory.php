<?php

namespace App\Models;

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

    public function OtherLanguges()
    {
        $this->hasMany([MainCategory::class, 'translation_lang']);
    }
}
