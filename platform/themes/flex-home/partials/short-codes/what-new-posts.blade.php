<section class="section pt-50 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="page-content">
                    <div class="post-group post-group--single">
                        <div class="post-group__header">
                            <h3 class="post-group__title">{{ __("What's new ?") }}</h3>
                        </div>
                        <div class="post-group__content">
                            <div class="row">
                                @foreach (get_latest_posts(7, []) as $post)
                                    @if ($loop->first)
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <article class="post post__vertical post__vertical--single">
                                                <div class="post__thumbnail">
                                                    <img src="{{ get_object_image($post->image, 'medium') }}" alt="{{ $post->name }}"><a href="{{ $post->url }}" class="post__overlay"></a>
                                                </div>
                                                <div class="post__content-wrap">
                                                    <header class="post__header">
                                                        <h3 class="post__title"><a href="{{ $post->url }}">{{ $post->name }}</a></h3>
                                                        <div class="post__meta"><span class="created__month">{{ date_from_database($post->created_at, 'M') }}</span><span class="created__date">{{ date_from_database($post->created_at, 'd') }}</span><span class="created__year">{{ date_from_database($post->created_at, 'Y') }}</span></div>
                                                    </header>
                                                    <div class="post__content">
                                                        <p data-number-line="4">{{ $post->description }}</p>
                                                    </div>
                                                    <div class="post__footer"><a href="{{ $post->url }}" class="post__readmore">{{ __('Read more') }}</a></div>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            @else
                                                <article class="post post__horizontal post__horizontal--single mb-20 clearfix">
                                                    <div class="post__thumbnail">
                                                        <img src="{{ get_object_image($post->image, 'medium') }}" alt="{{ $post->name }}"><a href="{{ $post->url }}" class="post__overlay"></a>
                                                    </div>
                                                    <div class="post__content-wrap">
                                                        <header class="post__header">
                                                            <h3 class="post__title"><a href="{{ $post->url }}">{{ $post->name }}</a></h3>
                                                            <div class="post__meta"><span class="post__created-at"><a href="#">{{ date_from_database($post->created_at, 'M d, Y') }}</a></span></div>
                                                        </header>
                                                    </div>
                                                </article>
                                            @endif
                                            @if ($loop->last)
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="page-sidebar">
                    {!! dynamic_sidebar('top_sidebar') !!}
                </div>
            </div>
        </div>
    </div>
</section>
