@extends('core/base::layouts.master')
@section('content')
    {!! Form::open(['url' => route('real-estate.settings'), 'class' => 'main-setting-form']) !!}
    <div class="max-width-1200">

        @if (!app()->environment('demo'))
            <div class="flexbox-annotated-section">
                <div class="flexbox-annotated-section-annotation">
                    <div class="annotated-section-title pd-all-20">
                        <h2>{{ trans('plugins/real-estate::real-estate.google_map') }}</h2>
                    </div>
                    <div class="annotated-section-description pd-all-20 p-none-t">
                        <p class="color-note">{{ trans('plugins/real-estate::real-estate.google_map_description') }}</p>
                    </div>
                </div>
                <div class="flexbox-annotated-section-content">
                    <div class="wrapper-content pd-all-20">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label class="text-title-field" for="google_map_api_key">{{ trans('plugins/real-estate::real-estate.api_key') }}</label>
                                <input type="text" class="form-control" name="google_map_api_key" value="{{ setting('google_map_api_key') }}" id="google_map_api_key">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="flexbox-annotated-section">
            <div class="flexbox-annotated-section-annotation">
                <div class="annotated-section-title pd-all-20">
                    <h2>{{ trans('plugins/real-estate::currency.currencies') }}</h2>
                </div>
                <div class="annotated-section-description pd-all-20 p-none-t">
                    <p class="color-note">{{ trans('plugins/real-estate::currency.setting_description') }}</p>
                </div>
            </div>
            <div class="flexbox-annotated-section-content">
                <div class="wrapper-content pd-all-20">
                <textarea name="currencies"
                          id="currencies"
                          class="hidden">{!! json_encode($currencies) !!}</textarea>
                    <textarea name="deleted_currencies"
                              id="deleted_currencies"
                              class="hidden"></textarea>
                    <div class="swatches-container">
                        <div class="header clearfix">
                            <div class="swatch-item">
                                {{ trans('plugins/real-estate::currency.name') }}
                            </div>
                            <div class="swatch-item">
                                {{ trans('plugins/real-estate::currency.symbol') }}
                            </div>
                            <div class="swatch-item swatch-decimals">
                                {{ trans('plugins/real-estate::currency.number_of_decimals') }}
                            </div>
                            <div class="swatch-item swatch-exchange-rate">
                                {{ trans('plugins/real-estate::currency.exchange_rate') }}
                            </div>
                            <div class="swatch-item swatch-is-prefix-symbol">
                                {{ trans('plugins/real-estate::currency.is_prefix_symbol') }}
                            </div>
                            <div class="swatch-is-default">
                                {{ trans('plugins/real-estate::currency.is_default') }}
                            </div>
                            <div class="remove-item">{{ trans('plugins/real-estate::currency.remove') }}</div>
                        </div>
                        <ul class="swatches-list">

                        </ul>
                        <a href="#" class="js-add-new-attribute">
                            {{ trans('plugins/real-estate::currency.new_currency') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="flexbox-annotated-section" style="border: none">
        </div>
        <div class="flexbox-annotated-section-annotation">
            &nbsp;
        </div>
        <div class="flexbox-annotated-section-content">
            <button class="btn btn-info" type="submit">{{ trans('plugins/real-estate::currency.save_settings') }}</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('footer')
    <script id="currency_template" type="text/x-custom-template">
        <li data-id="__id__" class="clearfix">
            <div class="swatch-item" data-type="title">
                <input type="text" class="form-control" value="__title__">
            </div>
            <div class="swatch-item" data-type="symbol">
                <input type="text" class="form-control" value="__symbol__">
            </div>
            <div class="swatch-item swatch-decimals" data-type="decimals">
                <input type="number" class="form-control" value="__decimals__">
            </div>
            <div class="swatch-item swatch-exchange-rate" data-type="exchange_rate">
                <input type="number" class="form-control" value="__exchangeRate__" step="0.00000001">
            </div>
            <div class="swatch-item swatch-is-prefix-symbol" data-type="is_prefix_symbol">
                <div class="ui-select-wrapper">
                    <select class="ui-select">
                        <option value="1" __isPrefixSymbolChecked__>{{ trans('plugins/real-estate::currency.before_number') }}</option>
                        <option value="0" __notIsPrefixSymbolChecked__>{{ trans('plugins/real-estate::currency.after_number') }}</option>
                    </select>
                    <svg class="svg-next-icon svg-next-icon-size-16">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                    </svg>
                </div>
            </div>
            <div class="swatch-is-default" data-type="is_default">
                <input type="radio" name="currencies_is_default" value="__position__" __isDefaultChecked__>
            </div>
            <div class="remove-item"><a href="#" class="font-red"><i class="fa fa-trash"></i></a></div>
        </li>
    </script>
@endpush
