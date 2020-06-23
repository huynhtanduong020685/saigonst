<div class="checkout-wrapper">
    <div class="payment-checkout-form">
        <form action="{{ route('payments.checkout') }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="name" value="{{ $name }}">
            <input type="hidden" name="amount" value="{{ $amount }}">
            <input type="hidden" name="return_url" value="{{ $returnUrl }}">
            <ul class="list-group list_payment_method">
                @if (setting('payment_stripe_status') == 1)
                    <li class="list-group-item">
                        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_stripe"
                               value="stripe" data-toggle="collapse" checked data-target=".payment_stripe_wrap"
                               data-parent=".list_payment_method">
                        <label for="payment_stripe" class="text-left">
                            {{ trans('plugins/payment::payment.payment_via_card') }}
                        </label>
                        <div class="payment_stripe_wrap payment_collapse_wrap collapse show">
                            <div class="card-checkout">
                                <div class="form-group">
                                    <div class="card-wrapper"></div>
                                </div>
                                <div class="form-group @if ($errors->has('number') || $errors->has('expiry')) has-error @endif">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input placeholder="{{ trans('plugins/payment::payment.card_number') }}"
                                                   class="form-control" type="text" name="number" data-stripe="number">
                                        </div>
                                        <div class="col-sm-3">
                                            <input placeholder="{{ trans('plugins/payment::payment.mm_yy') }}" class="form-control"
                                                   type="text" name="expiry" data-stripe="exp">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group @if ($errors->has('name') || $errors->has('cvc')) has-error @endif">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input placeholder="{{ trans('plugins/payment::payment.full_name') }}"
                                                   class="form-control" type="text" name="name" data-stripe="name">
                                        </div>
                                        <div class="col-sm-3">
                                            <input placeholder="{{ trans('plugins/payment::payment.cvc') }}" class="form-control"
                                                   type="text" name="cvc" data-stripe="cvc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="payment-stripe-key" data-value="{{ setting('payment_stripe_client_id') }}"></div>
                        </div>
                    </li>
                @endif
                @if (setting('payment_paypal_status') == 1)
                    <li class="list-group-item">
                        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_paypal"
                               value="paypal">
                        <label for="payment_paypal" class="text-left">{{ trans('plugins/payment::payment.payment_via_paypal') }}</label>
                    </li>
                @endif
            </ul>

            @if (setting('payment_stripe_status') == 1 || setting('payment_paypal_status') == 1)
                <br>
                <div class="text-center">
                    <button class="payment-checkout-btn btn btn-info">{{ __('Checkout') }}</button>
                </div>
            @endif
        </form>
    </div>
</div>
