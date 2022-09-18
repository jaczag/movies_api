<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MoviesTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Category $category;
    protected Movie $movie;

    public function test_user_can_fetch_list_of_movies()
    {
        $response = $this->actingAs($this->user)->getJson(route('movies.index'));
        $response->assertStatus(200);
    }

    public function test_unregistered_user_cannot_fetch_list_of_movies()
    {
        $response = $this->getJson(route('movies.index'));

        $response->assertStatus(401);
    }

    public function test_user_can_store_movie(): void
    {
        $response = $this->actingAs($this->user)->postJson(route('movies.store'), [
            'categories_ids' => [$this->category->id],
            'title' => 'Test Title',
            'production_country' => 'China',
            'description' => 'some description',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('movies', [
            'title' => 'Test Title',
            'production_country' => 'China',
            'description' => 'some description',
        ]);
    }

    public function test_unauthenticated_user_cannot_store_movie(): void
    {
        $response = $this->postJson(route('movies.store'), [
            'categories_ids' => [$this->category->id],
            'title' => fake()->name,
            'production_country' => fake()->country,
            'description' => fake()->text,
        ]);

        $response->assertStatus(401);
    }

    public function user_can_display_movie_details(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('movies.show', ['movie' => $this->movie->id]));

        $response->assertStatus(200);
        $response->assertStatus(200)
            ->assertJsonStructure([
                    "status" => 200,
                    "data" => [
                        'id' => $this->movie->id
                    ],
                    "message" => "Success",
                    "code" => 200,
                ]
            );
    }

    /**
     * setup basic state
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->Movie = Movie::factory()->create();
    }
}
