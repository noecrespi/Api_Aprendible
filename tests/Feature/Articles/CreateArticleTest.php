<?php

namespace Tests\Feature\Articles;

use App\Models\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function test_example(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(
            route('api.v1.articles.create'), 
            [
                'data' => [
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'Create title',
                        'slug' => 'ejmeplo-articulo',
                        'content' => 'Contenido del articulo'
                    ]
                ]
            ]);
            // verificación de codigo de estado
            $response->assertCreated();

            $article = Article::first();

            $response->assertHeader(
                'Location',
                route('api.v1.articles.show', $article)
            );

            $response->assertExactJson([
                'data' => [
                    'type' => 'articles',
                    'id' => (string) $article->getRouteKey(),
                    'attributes' => [
                        'title' => 'Create title',
                        'slug' => 'ejmeplo-articulo',
                        'content' => 'Contenido del articulo'
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $article)
                    ]
                ]
            ]);
    }
}
