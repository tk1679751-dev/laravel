<x-blog-layout>
    <x-slot name="title">Create New Post</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create New Post
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
        <form method="POST" action="{{ route('posts.store') }}" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Title *
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}"
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
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
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
                    value="{{ old('featured_image') }}"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('featured_image') border-red-500 @enderror"
                    placeholder="https://example.com/image.jpg (leave empty for random image)"
                >
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Leave empty to use a random image from Picsum
                </p>
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
                >{{ old('body') }}</textarea>
                @error('body')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a 
                    href="{{ route('posts.index') }}" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200"
                >
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"
                >
                    Create Post
                </button>
            </div>
        </form>
    </div>

    <x-slot name="sidebar">
        <!-- Writing Tips -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Writing Tips</h3>
            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">•</span>
                    Write a compelling title that grabs attention
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">•</span>
                    Choose the right category for your post
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">•</span>
                    Use clear paragraphs and good formatting
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">•</span>
                    Add a featured image to make it visually appealing
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">•</span>
                    Proofread before publishing
                </li>
            </ul>
        </div>

        <!-- Include default sidebar -->
        @include('partials.sidebar')
    </x-slot>
</x-blog-layout>