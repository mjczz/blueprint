<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\V1\PostController
 */
class PostControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $posts = factory(Post::class, 3)->create();

        $response = $this->get(route('post.index'));
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\V1\PostController::class,
            'store',
            \App\Http\Requests\PostStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $post = $this->faker->word;

        $response = $this->post(route('post.store'), [
            'post' => $post,
        ]);

        $posts = Post::query()
            ->where('post', $post)
            ->get();
        $this->assertCount(1, $posts);
        $post = $posts->first();
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\V1\PostController::class,
            'update',
            \App\Http\Requests\PostUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $post = factory(Post::class)->create();
        $post = $this->faker->word;

        $response = $this->put(route('post.update', $post), [
            'post' => $post,
        ]);
    }


    /**
     * @test
     */
    public function download_behaves_as_expected()
    {
        $post = factory(Post::class)->create();

        $response = $this->get(route('post.download'));
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $post = factory(Post::class)->create();
        $posts = factory(Post::class, 3)->create();

        $response = $this->get(route('post.show', $post));
    }
}
