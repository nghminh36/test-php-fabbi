<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\DishMeal;
use Illuminate\Http\Request;

class DishController extends Controller
{
    public function getRestaurant(Request $request)
    {
        $restaurant = Dish::with('meals')->whereHas('meals', function ($query) use ($request) {
            $query->where('id', $request->mealSelected);
        })->get()->unique('restaurant')->toArray();

        return response()->json($restaurant, 201);
    }

    public function getDishes(Request $request)
    {
        $dishes = Dish::whereHas('meals', function ($query) use ($request) {
            $query->where('id', $request->mealSelected);
        })->where('restaurant', $request->restaurantSelected)->get()->unique('name')->toArray();

        return response()->json($dishes, 201);
    }
}
