<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if($isOpen)
        @include('livewire.create')
    @endif

    <button wire:click="create()">Create New Post</button>

    <table class="table-fixed w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Body</th>
                <th class="px-4 py-2">Thumbnail</th>
                <th class="px-4 py-2">Category</th>
                <th class="px-4 py-2">Tags</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td class="border px-4 py-2">{{ $post->title }}</td>
                    <td class="border px-4 py-2">{{ $post->body }}</td>
                    <td class="border px-4 py-2">
                        @if ($post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="Thumbnail" class="w-16 h-16">
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $post->category->name }}</td>
                    <td class="border px-4 py-2">
                        @foreach($post->tags as $tag)
                            <span class="bg-gray-200 rounded-full px-2 text-xs">{{ $tag->name }}</span>
                        @endforeach
                    </td>
                    <td class="border px-4 py-2">
                        <button wire:click="edit({{ $post->id }})">Edit</button>
                        <button wire:click="delete({{ $post->id }})">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="border px-4 py-2">
                        @livewire('comment-component', ['postId' => $post->id])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
