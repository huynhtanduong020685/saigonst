@if (is_plugin_active('blog'))
    @php
        $featured = get_featured_posts(5);
        $featuredList = [];
        if (!empty($featured)) {
            $featuredList = $featured->pluck('id')->all();
        }
    @endphp

    @if (!empty($featured))
        <section class="section pt-50 pb-50 bg-lightgray">
            <div class="container">
                <div class="post-group post-group--hero">
                    @foreach ($featured as $feature_item)
                        @if ($loop->first)
                            <div class="post-group__left">
                                <article class="post post__inside post__inside--feature">
                                    <div class="post__thumbnail">
                                        <img src="{{ get_object_image($feature_item->image, 'featured') }}" alt="{{ $feature_item->name }}"><a href="{{ $feature_item->url }}" class="post__overlay"></a>
                                    </div>
                                    <header class="post__header">
                                        <h3 class="post__title"><a href="{{ $feature_item->url }}">{{ $feature_item->name }}</a></h3>
                                        <div class="post__meta"><span class="post-category"><i class="ion-cube"></i>
                                                @if (!$feature_item->categories->isEmpty())<a href="{{ $feature_item->categories->first()->url }}">{{ $feature_item->categories->first()->name }}</a>@endif
                                        </span>
                                            <span class="created_at"><i class="ion-clock"></i><a href="#">{{ date_from_database($feature_item->created_at, 'M d Y') }}</a></span>
                                            @if ($feature_item->user->username)
                                                <span class="post-author"><i class="ion-android-person"></i><span>{{ $feature_item->user->getFullName() }}</span></span>
                                            @endif
                                        </div>
                                    </header>
                                </article>
                            </div>
                            <div class="post-group__right">
                                @else
                                    <div class="post-group__item">
                                        <article class="post post__inside post__inside--feature post__inside--feature-small">
                                            <div class="post__thumbnail"><img src="{{ get_object_image($feature_item->image, 'medium') }}" alt="{{ $feature_item->name }}"><a href="{{ $feature_item->url }}" class="post__overlay"></a></div>
                                            <header class="post__header">
                                                <h3 class="post__title"><a href="{{ $feature_item->url }}">{{ $feature_item->name }}</a></h3>
                                            </header>
                                        </article>
                                    </div>
                                    @if ($loop->last)
                            </div>
                        @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif
