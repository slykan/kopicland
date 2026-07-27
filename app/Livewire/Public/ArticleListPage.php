<?php

namespace App\Livewire\Public;

use App\Models\Article;
use Livewire\Component;

class ArticleListPage extends Component
{
    public function render()
    {
        $articles = Article::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->get();

        return view('livewire.public.article-list-page', [
            'articles' => $articles,
        ])->title(__('site.nav.explore').' — '.config('site.name'));
    }
}
