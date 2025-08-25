<?php

namespace App\Livewire;

use App\Models\Page as PageModel;
use Livewire\Component;

class Page extends Component
{
    public $page;

    public function mount($slug)
    {
        $this->page = PageModel::whereSlug($slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.page')->title($this->page->name);
    }
}
