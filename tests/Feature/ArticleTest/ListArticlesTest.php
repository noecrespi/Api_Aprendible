<?php

namespace Tests\Feature\ArticleTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;

class ListArticlesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    // Crear un artículo específico 
    public function can_fetch_a_single_article()
    {
        $this->withoutExceptionHandling(); 
        
        $article = Article::factory()->create();

        $response = $this->getJson(route('api.v1.articles.show', $article))->dump();

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string ) $article->getRouteKey(),
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]
            ],
        ]);
    }
}
