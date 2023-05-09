<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function create()
    {
        $article = new Article();
        return view('article.create', compact('article'));
    }
    public function index()
    {
        $articles = Article::paginate();
        return view('article.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('article.show', compact('article'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:articles',
            'body' => 'required|min:1000'
        ]);
        $article = new Article();
        $article->fill($data);
        $article->save();
        $request->session()->flash('status', 'Task was successful!');
        return redirect()->route('articles.index');
    }
}
