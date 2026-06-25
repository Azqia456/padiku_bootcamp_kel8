@props([
    'title',
    'subtitle' => null,
    'image' => null,
    'overlay' => 'from-[#0A5C34]/90 to-[#0A5C34]/50',
])

<section class="relative rounded-2xl overflow-hidden mb-6 h-36 md:h-40 shadow-sm">
    @if($image)
        <img src="{{ asset('images/'.$image) }}" alt="{{ $title }}" class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-[#0A5C34] to-[#2E7D32]"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-r {{ $overlay }}"></div>
    <div class="relative z-10 h-full flex items-center px-6 md:px-8">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-white">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-green-100 text-sm mt-1">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
</section>
