<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\BlogCategory;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\Blog as BlogModel;

class Blog extends Component
{
    use WithPagination;

    public $search;
    public $category;
    public string $canonical;

    public function mount()
    {
        $this->search = request('search');
        $this->category = request('category');
        
    }
    #[Title('Posts')]
    public function render()
    {
        return view('livewire.frontend.blog',[
            'posts' => BlogModel::with('category')->when($this->search,function($query){
                            $query->where('title','LIKE',"%$this->search%")
                                ->orWhere('meta_keywords','LIKE',"%$this->search%");
                        })->when($this->category,function($query){
                            $query->whereHas('category',fn($query) => $query->where('slug',$this->category));
                        })->latest()->paginate(),
            'categories' => BlogCategory::withCount('posts')->get(),
            
        ]);
    }
}
