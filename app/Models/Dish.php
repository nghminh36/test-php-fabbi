<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $table = 'dishes';

    protected $fillable = [
        'id',
        'name',
        'restaurant'
    ];

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'dish_meals');
    }
}
