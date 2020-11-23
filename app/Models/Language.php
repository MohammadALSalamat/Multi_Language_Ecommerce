<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory, Notifiable;

    protected $table = "languages";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abbr',
        'locale',
        'name',
        'direction',
        'active',
        'created_at',
        'updated_at',
    ];
}
