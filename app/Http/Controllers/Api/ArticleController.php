<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\SaveArticleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{
    public function show(Article $article): ArticleResource
    {
        return ArticleResource::make($article);
    }

    public function index(Request $request): ArticleCollection
    {
        $articles = Article::query();

        if ($request->filled('sort')) {
            $sortFields = explode(',', $request->input('sort'));

            $allowedSorts = ['title', 'content'];

            foreach ($sortFields as $sortField) {
                $sortDirection = Str::of($sortField)->startsWith('-') ? 'desc' : 'asc';

                $sortField = ltrim($sortField, '-');

                abort_unless(in_array($sortField, $allowedSorts), 400);

                $articles->orderBy($sortField, $sortDirection);
            }
        }

        return ArticleCollection::make($articles->get());
    }

    public function store(SaveArticleRequest $request): ArticleResource
    {
        $article = Article::create($request->validated()['data']['attributes']);

        return ArticleResource::make($article);
    }

    public function update(Article $article, SaveArticleRequest $request): ArticleResource
    {
        $article->update($request->validated()['data']['attributes']);

        return ArticleResource::make($article);
    }

    public function destroy(Article $article): Response
    {
        $article->delete();

        return response()->noContent();
    }
}
