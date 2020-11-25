<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory, Notifiable;
    protected $table = "vendors";
    protected $fillable = [
        'name',
        'logo',
        'mobile',
        'address',
        'email',
        'category_id',
        'active',
        'created_at',
        'updated_at',
        'password'
    ];

    protected $hidden = [];


    public function category()
    {
        return $this->belongsTo("App\Models\MainCategory", 'category_id', 'id');
    }
}
