<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class PostComponent extends Component
{
    use WithFileUploads;

    public $posts, $title, $body, $thumbnail, $postId, $category_id, $tags = [];
    public $categories, $allTags;
    public $isOpen = false;

    public function mount()
    {
        $this->posts = Post::all();
        $this->categories = Category::all();
        $this->allTags = Tag::all();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->body = '';
        $this->thumbnail = '';
        $this->postId = '';
        $this->category_id = '';
        $this->tags = [];
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
            'thumbnail' => 'image|max:1024', 
            'category_id' => 'required',
            'tags' => 'required|array',
        ]);

        $thumbnailPath = $this->thumbnail ? $this->thumbnail->store('thumbnails', 'public') : null;

        $post = Post::updateOrCreate(['id' => $this->postId], [
            'title' => $this->title,
            'body' => $this->body,
            'thumbnail' => $thumbnailPath,
            'category_id' => $this->category_id,
        ]);

        $post->tags()->sync($this->tags);

        session()->flash('message', $this->postId ? 'Post updated successfully.' : 'Post created successfully.');

        $this->closeModal();
        $this->resetInputFields();
        $this->posts = Post::all();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->thumbnail = $post->thumbnail;
        $this->category_id = $post->category_id;
        $this->tags = $post->tags->pluck('id')->toArray();

        $this->openModal();
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post deleted successfully.');
        $this->posts = Post::all();
    }

    public function render()
    {
        return view('livewire.post-component');
    }
}
