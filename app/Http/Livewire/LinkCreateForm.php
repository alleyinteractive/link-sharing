<?php

namespace App\Http\Livewire;

use App\Models\Link;
use Livewire\Component;

class LinkCreateForm extends Component
{
    public string $url = '';

    public ?Link $link = null;

    protected $rules = [
        'url' => 'required|url',
    ];

    public function render()
    {
        return view('livewire.link-create-form');
    }

    public function submit()
    {
        $this->validate();

        $this->link = Link::create([
            'url' => $this->url,
            'user_id' => auth()->id(),
        ]);
    }
}
