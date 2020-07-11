<?php

namespace Tests\Feature\Http\Controllers;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PostController
 */
class PostControllerTest extends TestCase
{
    use RefreshDatabase;

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
