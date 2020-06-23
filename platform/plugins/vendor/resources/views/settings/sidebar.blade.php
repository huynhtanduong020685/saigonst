<div class="col-12 col-md-3">
  <div class="list-group mb-3 br2" style="box-shadow: rgb(204, 204, 204) 0px 1px 1px;">
    <div class="list-group-item fw6 bn light-gray-text">
      {{ trans('plugins/vendor::dashboard.sidebar_title') }}
    </div>
    <a href="{{ route('public.vendor.settings') }}" class="list-group-item list-group-item-action bn @if (Route::currentRouteName() == 'public.vendor.settings') active @endif">
      <i class="fas fa-user-circle mr-2"></i>
      <span>{{ trans('plugins/vendor::dashboard.sidebar_information') }}</span>
    </a>
      <a href="{{ route('public.vendor.packages') }}" class="list-group-item list-group-item-action bn @if (Route::currentRouteName() == 'public.vendor.packages') active @endif">
          <i class="fas fa-money-check-alt mr-2"></i>
          <span>{{ trans('plugins/vendor::dashboard.sidebar_packages') }}</span>
      </a>
    <a href="{{ route('public.vendor.security') }}" class="list-group-item list-group-item-action bn @if (Route::currentRouteName() == 'public.vendor.security') active @endif">
      <i class="fas fa-user-lock mr-2"></i>
      <span>{{ trans('plugins/vendor::dashboard.sidebar_security') }}</span>
    </a>
  </div>
</div>
