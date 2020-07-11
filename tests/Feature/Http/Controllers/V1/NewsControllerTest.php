<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\V1\NewsController
 */
class NewsControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $news = factory(News::class, 3)->create();

        $response = $this->get(route('news.index'));
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\V1\NewsController::class,
            'store',
            \App\Http\Requests\NewsStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $news = $this->faker->word;

        $response = $this->post(route('news.store'), [
            'news' => $news,
        ]);

        $news = News::query()
            ->where('news', $news)
            ->get();
        $this->assertCount(1, $news);
        $news = $news->first();
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $news = factory(News::class)->create();

        $response = $this->get(route('news.show', $news));
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\V1\NewsController::class,
            'update',
            \App\Http\Requests\NewsUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $news = factory(News::class)->create();
        $news = $this->faker->word;

        $response = $this->put(route('news.update', $news), [
            'news' => $news,
        ]);
    }
}
