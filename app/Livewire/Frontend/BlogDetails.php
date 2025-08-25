<?php

namespace App\Livewire\Frontend;

use App\Models\Blog;
use Livewire\Component;
use Livewire\Attributes\Locked;

class BlogDetails extends Component
{
    #[Locked]
    public $post;

    public function mount($slug)
    {
        $this->post = Blog::whereSlug($slug)->firstOrFail();
    }
    public function render()
    {
        return view('livewire.frontend.blog-details',[
            'related' => Blog::where('category_id',$this->post->category_id)->whereNot('id',$this->post->id)->limit(5)->get()
        ])->title($this->post->title);
    }
}
