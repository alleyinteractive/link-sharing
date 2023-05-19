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

        // Check if a link with the same URL already exists
        $link = Link::where('url', $this->url)->first();

        if ($link) {
            $this->link = $link;

            return;
        }

        // Prevent linking back to the app itself.
        if (str_starts_with($this->url, config('app.url'))) {
            $this->addError('url', 'You cannot link back to this app.');

            return;
        }

        $this->link = Link::create([
            'url' => $this->url,
            'user_id' => auth()->id(),
        ]);
    }
}
