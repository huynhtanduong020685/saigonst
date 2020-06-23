<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (theme_option('favicon'))
        <link rel="shortcut icon" href="{{ get_image_url(theme_option('favicon')) }}">
    @endif

  {!! SeoHelper::render() !!}

  <!-- Datetime picker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

  {!! Assets::renderHeader(['core']) !!}

  {!! Html::style('vendor/core/css/themes/default.css') !!}

  <!-- Styles -->
  <link href="{{ asset('vendor/core/plugins/vendor/css/app.css') }}" rel="stylesheet">

  <!-- Put translation key to translate in VueJS -->
  <script type="text/javascript">
      window.trans = JSON.parse('{!! addslashes(json_encode(trans('plugins/vendor::dashboard'))) !!}');
      var BotbleVariables = BotbleVariables || {};
      BotbleVariables.languages = {
        tables: {!! json_encode(trans('core/base::tables'), JSON_HEX_APOS) !!},
        notices_msg: {!! json_encode(trans('core/base::notices'), JSON_HEX_APOS) !!},
        pagination: {!! json_encode(trans('pagination'), JSON_HEX_APOS) !!},
        system: {
          'character_remain': '{{ trans('core/base::forms.character_remain') }}'
        }
      };
  </script>
</head>
<body>
  <div id="app">
    @include('plugins/vendor::components.header')
    <main class="pv3 pv4-ns">
        @if (auth('vendor')->check() && !auth('vendor')->user()->canPost())
            <div class="container">
                <div class="alert alert-warning">{{ __('Please upgrade your package to create your own properties here:') }}
                    <a href="{{ route('public.vendor.packages') }}">{{ __('Upgrade package') }}</a></div>
            </div>
            <br>
        @endif
      @yield('content')
    </main>
  </div>

  @if (session()->has('status') || session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
    <script type="text/javascript">
      window.noticeMessages = [];
      @if (session()->has('success_msg'))
        noticeMessages.push({'type': 'success', 'message': "{!! addslashes(session('success_msg')) !!}"});
      @endif
      @if (session()->has('status'))
      noticeMessages.push({'type': 'success', 'message': "{!! addslashes(session('status')) !!}"});
      @endif
      @if (session()->has('error_msg'))
        noticeMessages.push({'type': 'error', 'message': "{!! addslashes(session('error_msg')) !!}"});
      @endif
      @if (isset($error_msg))
        noticeMessages.push({'type': 'error', 'message': "{!! addslashes($error_msg) !!}"});
      @endif
      @if (isset($errors))
        @foreach ($errors->all() as $error)
          noticeMessages.push({'type': 'error', 'message': "{!! addslashes($error) !!}"});
        @endforeach
      @endif
    </script>
  @endif

  <!-- Scripts -->
  <script src="{{ asset('vendor/core/plugins/vendor/js/app.js') }}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
  {!! Assets::renderFooter() !!}
  @stack('scripts')
  @include('core/media::partials.media')
</body>
</html>
