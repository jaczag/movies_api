<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    /**
     * @return void
     */
    public function test_get_list_of_available_movie_categories(): void
    {
        Category::factory(5)->create();

        $response = $this->getJson(route('categories'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                    "status",
                    "data" => [
                        [
                            'id',
                            'name'
                        ]
                    ],
                    "message",
                    "code",
                ]
            );
    }
}
