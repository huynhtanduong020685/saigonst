@php Theme::set('section-name', __('Galleries')) @endphp

<article class="post post--single">
    <div class="post__content">
        @if (isset($galleries) && !$galleries->isEmpty())
            <div class="gallery-wrap">
                @foreach ($galleries as $gallery)
                    <div class="gallery-item">
                        <div class="img-wrap">
                            <a href="{{ route('public.gallery', $gallery->slug) }}"><img src="{{ get_object_image($gallery->image, 'medium') }}" alt="{{ $gallery->name }}"></a>
                        </div>
                        <div class="gallery-detail">
                            <div class="gallery-title"><a href="{{ route('public.gallery', $gallery->slug) }}">{{ $gallery->name }}</a></div>
                            <div class="gallery-author">{{ __('By') }} {{ $gallery->user->getFullName() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</article>
