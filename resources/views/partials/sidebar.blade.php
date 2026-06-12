<!-- Search Widget -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Search Posts</h3>
    <form method="GET" action="{{ route('posts.index') }}" class="space-y-3">
        <div>
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Search posts..." 
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
            >
        </div>
        <button 
            type="submit" 
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"
        >
            Search
        </button>
        @if(request('search'))
            <a 
                href="{{ route('posts.index') }}" 
                class="block text-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
            >
                Clear search
            </a>
        @endif
    </form>
</div>

<!-- Categories Widget -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Categories</h3>
    <div class="space-y-2">
        @php
            $categories = \App\Models\Category::withCount('posts')->get();
        @endphp
        
        @foreach($categories as $category)
            <a 
                href="{{ route('categories.show', $category) }}" 
                class="flex justify-between items-center py-2 px-3 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200 {{ request()->route('category')?->id == $category->id ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 'text-gray-700 dark:text-gray-300' }}"
            >
                <span>{{ $category->name }}</span>
                <span class="text-sm bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full">
                    {{ $category->posts_count }}
                </span>
            </a>
        @endforeach
    </div>
</div>

<!-- Recent Posts Widget -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Posts</h3>
    <div class="space-y-4">
        @php
            $recentPosts = \App\Models\Post::with(['user', 'category'])
                ->latest()
                ->take(5)
                ->get();
        @endphp
        
        @foreach($recentPosts as $recentPost)
            <div class="flex space-x-3">
                <img 
                    src="{{ $recentPost->featured_image }}" 
                    alt="{{ $recentPost->title }}"
                    class="w-16 h-16 object-cover rounded-md flex-shrink-0"
                >
                <div class="flex-1 min-w-0">
                    <a 
                        href="{{ route('posts.show', $recentPost) }}" 
                        class="block text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 line-clamp-2"
                    >
                        {{ $recentPost->title }}
                    </a>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ $recentPost->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>

@auth
<!-- User Actions Widget -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
    <div class="space-y-3">
        <a 
            href="{{ route('posts.create') }}" 
            class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md text-center transition duration-200"
        >
            Write New Post
        </a>
        
        @php
            $userPosts = \App\Models\Post::where('user_id', auth()->id())->count();
            $userComments = \App\Models\Comment::where('user_id', auth()->id())->count();
        @endphp
        
        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
            <p>Your posts: <span class="font-medium">{{ $userPosts }}</span></p>
            <p>Your comments: <span class="font-medium">{{ $userComments }}</span></p>
        </div>
    </div>
</div>
@endauth