<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->lastName,
            'name' => $this->faker->unique()->lastName,
            'image' => 'product04.png',
            'cate_id' => function () {
                        return Category::query()->inRandomOrder()->first()->id;
            },
            'brand_id' => function () {
                        return Brand::query()->inRandomOrder()->first()->id;
            },
            'price' => $this->faker->numberBetween(1000, 4000)
        ];
    }
}
