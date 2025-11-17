<x-public-layout>
    <x-slot name="title">{{ $post->title }}</x-slot>

    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <header class="mb-8">
            <div class="mb-4">
                <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    ← Retour au blog
                </a>
            </div>

            <span class="inline-block px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full mb-4">
                {{ ucfirst($post->category) }}
            </span>

            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

            <div class="flex items-center text-gray-600 text-sm space-x-4">
                <span>Par {{ $post->author->name }}</span>
                <span>•</span>
                <span>{{ $post->published_at->format('d F Y') }}</span>
                <span>•</span>
                <span>{{ $post->views }} vues</span>
            </div>
        </header>

        <!-- Featured Image -->
        @if($post->featured_image)
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-lg mb-8">
        @endif

        <!-- Content -->
        <div class="prose prose-lg max-w-none mb-12">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Tags -->
        @if($post->tags && count($post->tags) > 0)
            <div class="border-t border-gray-200 pt-6 mb-8">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Tags:</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">#{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Articles similaires</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            @if($related->featured_image)
                                <img src="{{ $related->featured_image }}" alt="{{ $related->title }}" class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gradient-to-br from-blue-400 to-blue-600"></div>
                            @endif
                            <div class="p-4">
                                <h4 class="font-bold text-gray-900 mb-2 line-clamp-2">
                                    <a href="{{ route('blog.show', $related->slug) }}" class="hover:text-blue-600">
                                        {{ $related->title }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $related->excerpt }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
</x-public-layout>
