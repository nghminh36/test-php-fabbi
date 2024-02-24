<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = json_decode(file_get_contents(storage_path() . "/dishes.json"), true);

        $meals = ["breakfast", "lunch", "dinner"];

        foreach ($meals as $meal) {
            DB::table('meals')->insert([
                "name" => $meal
            ]);
        }

        foreach ($data as $item) {
            Log::info($item['name']);
            DB::table('dishes')->insert([
                "id" => $item['id'],
                "name" => $item['name'],
                "restaurant" => $item['restaurant']
            ]);

            foreach ($item['availableMeals'] as $avail) {
                Log::info($avail);
                Log::info($avail == 'breakfast');
                DB::table('dish_meals')->insert([
                    "meal_id" => $avail == 'breakfast' ? 1 : ($avail == 'lunch' ? 2 : 3),
                    "dish_id" => $item['id']
                ]);
            }
        }
    }
}
