<x-blog-layout>
    <x-slot name="title">Edit Post: {{ $post->title }}</x-slot>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Post: {{ Str::limit($post->title, 50) }}
            </h2>
            <a 
                href="{{ route('posts.show', $post) }}" 
                class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
            >
                View Post
            </a>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
        <form method="POST" action="{{ route('posts.update', $post) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Title *
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title', $post->title) }}"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror"
                    placeholder="Enter post title..."
                    required
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Category *
                </label>
                <select 
                    name="category_id" 
                    id="category_id" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('category_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option 
                            value="{{ $category->id }}" 
                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Image URL -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Featured Image URL
                </label>
                <input 
                    type="url" 
                    name="featured_image" 
                    id="featured_image" 
                    value="{{ old('featured_image', $post->featured_image) }}"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('featured_image') border-red-500 @enderror"
                    placeholder="https://example.com/image.jpg"
                >
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <!-- Current Image Preview -->
                @if($post->featured_image)
                    <div class="mt-3">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current image:</p>
                        <img 
                            src="{{ $post->featured_image }}" 
                            alt="Current featured image" 
                            class="w-32 h-24 object-cover rounded-md"
                        >
                    </div>
                @endif
            </div>

            <!-- Body -->
            <div>
                <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Content *
                </label>
                <textarea 
                    name="body" 
                    id="body" 
                    rows="12" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('body') border-red-500 @enderror"
                    placeholder="Write your post content here..."
                    required
                >{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a 
                    href="{{ route('posts.show', $post) }}" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200"
                >
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"
                >
                    Update Post
                </button>
            </div>
        </form>
    </div>

    <x-slot name="sidebar">
        <!-- Post Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Post Statistics</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Created:</span>
                    <span class="text-gray-900 dark:text-white">{{ $post->created_at->format('M j, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Last updated:</span>
                    <span class="text-gray-900 dark:text-white">{{ $post->updated_at->format('M j, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Comments:</span>
                    <span class="text-gray-900 dark:text-white">{{ $post->comments->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Category:</span>
                    <span class="text-gray-900 dark:text-white">{{ $post->category->name }}</span>
                </div>
            </div>
        </div>

        <!-- Editing Tips -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Editing Tips</h3>
            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    Make sure your changes improve the content
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    Check for spelling and grammar errors
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    Update the category if the topic changed
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    Consider updating the featured image
                </li>
            </ul>
        </div>

        <!-- Include default sidebar -->
        @include('partials.sidebar')
    </x-slot>
</x-blog-layout>