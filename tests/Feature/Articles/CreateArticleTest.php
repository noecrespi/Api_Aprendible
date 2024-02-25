<?php

namespace Tests\Feature\Articles;

use App\Models\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;

use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_create_articles(): void
    {
        // $this->withoutExceptionHandling();
        $response = $this->postJson(
            route('api.v1.articles.store'),
            [
                'data' => [
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'Create title',
                        'slug' => 'ejmeplo-articulo',
                        'content' => 'Contenido del articulo'
                    ]
                ]
            ]
        );
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

    /**
     * @test
     */
    // el titulo es requerido 
    public function title_is_required(): void
    {
        $response = $this->postJson(
            route('api.v1.articles.store'),
            [
                'data' => [
                    'type' => 'articles',
                    'attributes' => [
                        // 'title' => 'Create title',
                        'slug' => 'ejmeplo-articulo',
                        'content' => 'Contenido del articulo'
                    ]
                ]
            ]
                    );

                    
        // verificación de codigo de estado
        // $response->assertJsonApiValidationErrors('data.attributes.title');

        //verificar la estructura del objeto error
        // $response->assertJsonStructure([
        //     'errors' => [
        //         ['title', 'detail', 'source' => ['pointer']]
        //     ]
        // ])->assertJsonFragment([
        //     'source' => ['pointer' => '/data/attributes/title']
        // ])->assertHeader(
        //     'content-type',
        //     'application/vnd.api+json'
        // )->assertStatus(422);

        $response->assertJsonApiValidationErrors('title');

    }

    /**
     * @test
     */
    // el slug es requerido 
    public function slug_is_required(): void
    {
        $response = $this->postJson(
            route('api.v1.articles.store'),
            [
                'data' => [
                    'type' => 'articles',
                    'attributes' => [
                        // 'title' => 'Create title',
                        'title' => 'Nuevo Articulo',
                        'content' => 'Contenido del artículo'
                    ]
                ]
            ]
        );
        // verificación de codigo de estado
        $response->assertJsonApiValidationErrors('slug');
    }

    /**
     * @test
     */
    // el contenido es requerido 
    public function content_is_required(): void
    {
        $response = $this->postJson(
            route('api.v1.articles.store'),
            [
                'data' => [
                    'type' => 'articles',
                    'attributes' => [
                        // 'title' => 'Create title',
                        'title' => 'Nuevo Articulo',
                        'slug' => 'nuevo-articulo'
                    ]
                ]
            ]
        );
        // verificación de codigo de estado
        // $response->assertJsonValidationErrors('data.attributes.content');

        // $response->assertJsonStructure([
        //     'errors' => [
        //         ['title', 'detail', 'source' => ['pointer']]
        //     ]
        // ])->assertJsonFragment([
        //     'source' => ['pointer' => '/data/attributes/title']
        // ])->assertHeader(
        //     'content-type',
        //     'application/vnd.api+json'
        // )->assertStatus(422);
        $response->assertJsonApiValidationErrors('content');
    }

    /**
     *  @test 
     */
    //el titulo tiene que tener minimo 4 caracteres
    public function title_must_be_at_least_4_characters()
    {
        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'Nue',
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del artículo'
                ]
            ]
        ]);

        $response->assertJsonApiValidationErrors('title');  
    }
}
