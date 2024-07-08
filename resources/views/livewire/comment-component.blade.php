<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div>
        <form wire:submit.prevent="store">
            <textarea wire:model="content" placeholder="Add a comment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            @error('content') <span class="text-red-500">{{ $message }}</span>@enderror

            <button type="submit" class="mt-2 inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Submit
            </button>
        </form>
    </div>

    <div class="mt-4">
        @foreach($comments as $comment)
            <div class="border p-2 mt-2">
                <p>{{ $comment->content }}</p>
                <small>Posted at {{ $comment->created_at->format('d M Y, H:i') }}</small>

                <!-- tambahan comment to comment -->
                <button wire:click="$emit('replyComment', {{ $comment->id }})" class="text-blue-500">Reply</button>
                
                @livewire('comment-component', ['postId' => $postId, 'parentId' => $comment->id], key('comment-'.$comment->id))

                @foreach($comment->replies as $reply)
                    <div class="ml-4 border p-2 mt-2">
                        <p>{{ $reply->content }}</p>
                        <small>Posted at {{ $reply->created_at->format('d M Y, H:i') }}</small>
                    </div>
                @endforeach

            </div>
        @endforeach
    </div>
</div>
