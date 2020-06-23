<main class="detailproject" style="background: #FFF;">
    <div class="boxsliderdetail">
        <div class="slidetop">
            <div class="owl-carousel" id="listcarousel">
                @foreach ($project->images as $image)
                    <div class="item"><img  src="{{ get_object_image($image) }}" class="showfullimg" rel="{{ $loop->index }}" alt="{{ $project->name }}"></div>
                @endforeach
            </div>
        </div>
        <div class="slidebot">
            <div style="max-width: 800px; margin: 0 auto;">
                    <div class="owl-carousel" id="listcarouselthumb">
                        @foreach ($project->images as $image)
                            <div class="item cthumb" rel="{{ $loop->index }}"><img  src="{{ get_object_image($image) }}" class="showfullimg" rel="{{ $loop->index }}" alt="{{ $project->name }}"></div>
                        @endforeach
                    </div>
                    <i class="fas fa-chevron-right ar-next"></i>
                    <i class="fas fa-chevron-left ar-prev"></i>
            </div>
        </div>
    </div>
    <div id="gallery" data-images="{{ json_encode($images) }}"></div>

    <div class="container-fluid bgmenupro">
        <div class="container-fluid w90 padtop30" style="padding: 15px 0;">
            <div class="col-12">
                <h1 class="title" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0;">{{ $project->name }}</h1>
                <p class="addresshouse"><i class="fas fa-map-marker-alt"></i>  {{ $project->location }}</p>
            </div>
        </div>
    </div>

    <div class="container-fluid w90 padtop30 single-post">
        <section class="general">
            <div class="row">
                <div class="col-md-8">
                    <div class="head">{{ __('Book A Tour') }}</div>
                    @if ($project->content)
                        {!! $project->content !!}
                    @else
                        <p>{{ __('Updating...') }}</p>
                    @endif
                    <br>
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe id="gmap_canvas" width="100%" height="500"
                                    src="https://maps.google.com/maps?q={{ urlencode($project->location) }}%20&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        </div>
                    </div>
                    <br>
                    <br>
                    {!! Theme::partial('share', ['title' => __('Share this book a tour'), 'description' => $project->description]) !!}
                    <div class="clearfix"></div>
                    <br>
                </div>
                <div class="col-md-4 padtop10">
                    <div class="boxright">
                        {!! Theme::partial('consult-form', ['type' => 'project', 'data' => $project]) !!}
                    </div>
                </div>
            </div>

            <!-- <h5  class="headifhouse">{{ __('Extra Curricular Activities') }}</h5>
            <property-component type="project-properties-for-sell" project_id="{{ $project->id }}" url="{{ route('public.ajax.properties') }}" :show_empty_string="true"></property-component>
            <br>
            <br>
            <h5  class="headifhouse">{{ __('Summer School') }}</h5>
            <property-component type="project-properties-for-rent" project_id="{{ $project->id }}" url="{{ route('public.ajax.properties') }}" :show_empty_string="true"></property-component> -->
            <br>
            <br>
            <br>
            <br>
            <br>
        </section>

    </div>
</main>
<br>
<br>
