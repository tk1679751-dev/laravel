<x-blog-layout>
    <x-slot name="title">{{ $post->title }}</x-slot>

    <x-slot name="header">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>
                
                <!-- Post Meta -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ substr($post->user->name, 0, 1) }}
                            </span>
                        </div>
                        <span>{{ $post->user->name }}</span>
                    </div>
                    
                    <span>•</span>
                    <span>{{ $post->created_at->format('M j, Y') }}</span>
                    
                    <span>•</span>
                    <a 
                        href="{{ route('categories.show', $post->category) }}" 
                        class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition duration-200"
                    >
                        {{ $post->category->name }}
                    </a>
                    
                    <span>•</span>
                    <span>{{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}</span>
                </div>
            </div>
            
            @can('update', $post)
                <div class="flex space-x-2 ml-4">
                    <a 
                        href="{{ route('posts.edit', $post) }}" 
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200"
                    >
                        Edit
                    </a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200"
                        >
                            Delete
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </x-slot>

    <!-- Featured Image -->
    <div class="mb-8">
        <img 
            src="{{ $post->featured_image }}" 
            alt="{{ $post->title }}"
            class="w-full h-64 md:h-96 object-cover rounded-lg shadow-sm"
        >
    </div>

    <!-- Post Content -->
    <article class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 mb-8">
        <div class="prose prose-lg max-w-none text-gray-900 dark:text-gray-100" style="color: inherit;">
            <div class="text-gray-900 dark:text-gray-100" style="color: inherit;">
                {!! nl2br(e($post->body)) !!}
            </div>
        </div>
    </article>

    <!-- Comments Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
            Comments ({{ $post->comments->count() }})
        </h3>

        @auth
            <!-- Add Comment Form -->
            <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-8">
                @csrf
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Add a comment
                    </label>
                    <textarea 
                        name="content" 
                        id="content" 
                        rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('content') border-red-500 @enderror"
                        placeholder="Write your comment here..."
                        required
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button 
                    type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"
                >
                    Post Comment
                </button>
            </form>
        @else
            <div class="mb-8 p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                <p class="text-gray-600 dark:text-gray-400">
                    <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Login</a> 
                    or 
                    <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline">register</a> 
                    to leave a comment.
                </p>
            </div>
        @endauth

        <!-- Comments List -->
        @if($post->comments->count() > 0)
            <div class="space-y-6">
                @foreach($post->comments as $comment)
                    <div class="border-l-4 border-gray-200 dark:border-gray-600 pl-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            
                            @can('delete', $comment)
                                <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="text-red-600 hover:text-red-800 text-sm"
                                    >
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                        
                        <div class="text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($comment->content)) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                No comments yet. Be the first to comment!
            </p>
        @endif
    </div>

    <!-- Related Posts Sidebar -->
    <x-slot name="sidebar">
        @if($relatedPosts->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Related Posts</h3>
                <div class="space-y-4">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="flex space-x-3">
                            <img 
                                src="{{ $relatedPost->featured_image }}" 
                                alt="{{ $relatedPost->title }}"
                                class="w-16 h-16 object-cover rounded-md flex-shrink-0"
                            >
                            <div class="flex-1 min-w-0">
                                <a 
                                    href="{{ route('posts.show', $relatedPost) }}" 
                                    class="block text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 line-clamp-2"
                                >
                                    {{ $relatedPost->title }}
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $relatedPost->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Include default sidebar -->
        @include('partials.sidebar')
    </x-slot>
</x-blog-layout>