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
    public function can_create_articles()
    {
        $response = $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo artículo',
            'slug' => 'nuevo-articulo',
            'content' => 'Contenido del artículo'
        ])->assertCreated();

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
                    'title' => 'Nuevo artículo',
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del artículo'
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
        $this->postJson(route('api.v1.articles.store'), [
            'slug' => 'nuevo-articulo',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('title');
    }

    /**
     * @test
     */
    // el slug es requerido 
    public function slug_is_required(): void
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo Articulo',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }
    /** @test */
    public function slug_must_be_unique()
    {
        $article = Article::factory()->create();

        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo Articulo',
            'slug' => $article->slug,
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_only_contain_letters_numbers_and_dashes()
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo Articulo',
            'slug' => '$%^&',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_not_contain_underscores()
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo Articulo',
            'slug' => 'with_underscores',
            'content' => 'Contenido del artículo'
        ])->assertSee(trans('validation.no_underscores', [
            'attribute' => 'data.attributes.slug'
        ]))->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_not_start_with_dashes()
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo Articulo',
            'slug' => '-starts-with-dashes',
            'content' => 'Contenido del artículo'
        ])->assertSee(trans('validation.no_starting_dashes', [
            'attribute' => 'data.attributes.slug'
        ]))->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_not_end_with_dashes()
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo Articulo',
            'slug' => 'end-with-dashes-',
            'content' => 'Contenido del artículo'
        ])->assertSee(trans('validation.no_ending_dashes', [
            'attribute' => 'data.attributes.slug'
        ]))->assertJsonApiValidationErrors('slug');
    }


    /**
     * @test
     */
    // el contenido es requerido 
    public function content_is_required(): void
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo Articulo',
            'slug' => 'nuevo-articulo'
        ])->assertJsonApiValidationErrors('content');
    }

    /**
     *  @test 
     */
    //el titulo tiene que tener minimo 4 caracteres
    public function title_must_be_at_least_4_characters()
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nue',
            'slug' => 'nuevo-articulo',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('title');
    }
}
