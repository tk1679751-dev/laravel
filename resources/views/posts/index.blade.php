<x-blog-layout>
    <x-slot name="title">
        @if(isset($category))
            Posts in {{ $category->name }}
        @elseif(request('search'))
            Search Results for "{{ request('search') }}"
        @else
            Latest Posts
        @endif
    </x-slot>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                @if(isset($category))
                    Posts in {{ $category->name }}
                @elseif(request('search'))
                    Search Results for "{{ request('search') }}"
                @else
                    Latest Posts
                @endif
            </h2>
            @auth
                <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                    Write New Post
                </a>
            @endauth
        </div>
    </x-slot>

    <!-- Posts Grid -->
    @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @foreach($posts as $post)
                <article class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-200">
                    <!-- Featured Image -->
                    <div class="aspect-video overflow-hidden">
                        <img 
                            src="{{ $post->featured_image }}" 
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover hover:scale-105 transition duration-300"
                        >
                    </div>
                    
                    <!-- Post Content -->
                    <div class="p-6">
                        <!-- Category & Date -->
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-3">
                            <a 
                                href="{{ route('categories.show', $post->category) }}" 
                                class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition duration-200"
                            >
                                {{ $post->category->name }}
                            </a>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                            <a 
                                href="{{ route('posts.show', $post) }}" 
                                class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-200"
                            >
                                {{ $post->title }}
                            </a>
                        </h3>
                        
                        <!-- Excerpt -->
                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($post->body), 150) }}
                        </p>
                        
                        <!-- Author & Comments -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $post->user->name }}</span>
                            </div>
                            
                            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    {{ $post->comments->count() }}
                                </span>
                                <a 
                                    href="{{ route('posts.show', $post) }}" 
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium"
                                >
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No posts found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    @if(request('search'))
                        No posts match your search criteria.
                    @elseif(isset($category))
                        No posts in this category yet.
                    @else
                        Get started by creating your first post.
                    @endif
                </p>
                @auth
                    <div class="mt-6">
                        <a 
                            href="{{ route('posts.create') }}" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Write your first post
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    @endif
</x-blog-layout>