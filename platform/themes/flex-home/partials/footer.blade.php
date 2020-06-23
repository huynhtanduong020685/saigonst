<!--FOOTER-->
<footer>
    <br>
    <div class="container-fluid w90">
        <div class="row">
            <div class="col-sm-3">
                @if (theme_option('logo'))
                <p>
                    <a href="{{ route('public.single') }}">
                        <img src="{{ get_image_url(theme_option('logo'))  }}" style="max-height: 38px" alt="{{ theme_option('site_name') }}">
                    </a>
                </p>
                @endif
                <p><i class="fas fa-map-marker-alt"></i> &nbsp;{{ theme_option('address') }}</p>
                <p><i class="fas fa-phone-square"></i> &nbsp;<a href="tel:{{ theme_option('hotline') }}">{{ theme_option('hotline') }}</a></p>
                <p><i class="fas fa-tty"></i> &nbsp;<a href="tel:{{ theme_option('hotline') }}">(+84)28 3742 3222</a></p>
                <p><i class="fas fa-envelope"></i>  &nbsp;<a href="mailto:{{ theme_option('email') }}">{{ theme_option('email') }}</a>
                </p>
            </div>
            <div class="col-sm-9 padtop10">
                <div class="row">
                    {!! dynamic_sidebar('footer_sidebar') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! Theme::partial('language-switcher') !!}
            </div>
        </div>
        <div class="copyright">
            <div class="col-sm-12">
                <p class="text-center">
                    {!! clean(theme_option('copyright')) !!}
                </p>
            </div>
        </div>
    </div>
</footer>
<!--FOOTER-->

<script type="text/javascript">
    window.trans = {
        "Price": "{{ __('Price') }}",
        "Number of rooms": "{{ __('Number of rooms') }}",
        "Number of rest rooms": "{{ __('Number of rest rooms') }}",
        "Square": "{{ __('Square') }}",
        "No property found": "{{ __('No property found') }}",
        "million": "{{ __('million') }}",
        "billion": "{{ __('billion') }}"
    }
</script>
<a href="http://sgstar.edu.vn/projects/book-a-parent-tour" class="social_open" id="bt_open">Book a tour</a>
<!-- <div class="social_group">
      <div class="group_1">
      <a href="http://sgstar.edu.vn/projects/book-a-parent-tour" target="_blank" class="download">Book a tour</a>
      </div> 
</div> -->


