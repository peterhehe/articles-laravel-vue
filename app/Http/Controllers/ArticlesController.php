<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validations\ArticleRequestValidation;
use Illuminate\Validation\ValidationException;
use App\Article;
use App\Tag;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticlesResource;
use Storage;
use Illuminate\Support\Carbon;

class ArticlesController extends Controller
{
    /**
     * Display a article.
     *
     * @return \Illuminate\Http\Response
     */
    public function getArticleForUpdate($id)
    {
        return new ArticleResource(Article::findOrFail($id));
    }

    /**
     * Display a article.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPublishedArticle($article_name)
    {
        return new ArticleResource(Article::whereNotNull('published_at')
            ->where('title', str_replace('-', ' ', $article_name))->firstOrFail());
    }


    /**
     * Display all articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function getArticles(Request $request)
    {
        $limit = $request->query('limit', 10);
        $results = Article::orderBy('updated_at', 'desc')->paginate($limit);

        // format paginated results
        $articles = $results->map(function ($article) {
            foreach ($article->tags as $articleTag) {
                $tags[] = $articleTag->tag;
            }

            return [
                "id"            => $article->id,
                "type"          => 'article',
                "attributes"    => [
                    "title"             => $article->title,
                    "photo"             => $article->photo,
                    "content"           => nl2br($article->content),
                    "tags"              => $tags ?? [],
                    "created_at"        => $article->created_at->format('Y-m-d H:i:s'),
                    "updated_at"        => $article->updated_at->format('Y-m-d H:i:s'),
                    "published_at"      => optional($article->published_at)->format('Y-m-d H:i:s'),
                    'slugcase'         => str_replace(' ', '-', strtolower($article->title))
                ]
            ];
        });

        $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
            $articles,
            $results->total(),
            $results->perPage(),
            $results->currentPage(),
            [
                'path' => $results->url($results->currentPage()),
                'query' => [
                    'page' => $results->currentPage()
                ]
            ]
        );
        return ['data' => new ArticlesResource($pagination)];
    }

    /**
     * Create a new article
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // validate field
        $this->validate($request, ArticleRequestValidation::getRules(), ArticleRequestValidation::getMessages());

        $isPublished = filter_var($request->publish, FILTER_VALIDATE_BOOLEAN) ?? false;

        // save image to local storage
        $data = $request->all();
        $data = $this->saveImage($data);
        $data['published_at'] =  $isPublished ? Carbon::now() : null;
        
        // create parent and children
        $article = Article::create($data);
        
        foreach ($data['tags'] ?? [] as $articleTag) {
            Tag::create([
                'tag'           => $articleTag,
                'article_id'    => $article->id
            ]);
        }
        
        return new ArticleResource($article);
    }

    /**
     * Edit an article.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // validate parameters
        $article = Article::findorFail($id);
        $this->validate($request, ArticleRequestValidation::getRules(), ArticleRequestValidation::getMessages());
        $isPublished = filter_var($request->publish, FILTER_VALIDATE_BOOLEAN) ?? false;
        // save new to local storage
        $data = $request->all();
        if (isset($data['photo'])) {
            $data = $this->saveImage($data);
        }
        // delete current tags and persist new ones
        $article->tags()->forceDelete();

        $article->title = $data['title'];
        $article->content = $data['content'];
        $article->photo = $data['photo'] ?? $article->photo;
        $article->published_at =  $isPublished ? Carbon::now() : null;

        $article->save();
               
        foreach ($data['tags'] ?? [] as $articleTag) {
            Tag::create([
                'tag'           => $articleTag,
                'article_id'    => $article->id
            ]);
        }
        dd($article->fresh());
        return new ArticleResource($article->fresh());
    }

    /**
     * Soft delete an article.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Article::findorFail($id)->delete();

        return ['success'];
    }

    private function saveImage(array &$data): array
    {
        // save image to local storage
        $filename = $data['photo']->getClientOriginalName();
        if (!Storage::exists("public/images/{$filename}")) {
            $image = $data['photo']->storeAs('images', $filename, 'public');
        }

        $data['photo'] = $filename;

        return $data;
    }
}
