@extends('plugins/vendor::layouts.skeleton')
@section('content')
    <div class="settings">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xs-12">
                    @include('plugins/payment::partials.form', [
                        'amount'    => $package->price,
                        'name'      => $package->name,
                        'returnUrl' => route('public.vendor.package.subscribe.callback', $package->id),
                    ])
                </div>
            </div>
        </div>
    </div>
@stop
