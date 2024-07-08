<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;

class CommentComponent extends Component
{
    public $postId;
    public $content;
    public $parentId;

    public function mount($postId, $parentId = null)
    {
        $this->postId = $postId;
        $this->parentId = $parentId;
    }

    public function store()
    {
        $this->validate([
            'content' => 'required',
        ]);

        Comment::create([
            'content' => $this->content,
            'post_id' => $this->postId,
            'parent_id' => $this->parentId,
        ]);

        session()->flash('message', 'Comment added successfully.');
        $this->reset('content');
        $this->emit('commentAdded');
    }

    public function render()
    {
        return view('livewire.comment-component', [
            'comments' => Comment::where('post_id', $this->postId)->whereNull('parent_id')->latest()->get(),
        ]);
    }
}