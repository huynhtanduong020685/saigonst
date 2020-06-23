'use strict';

var BPayment = BPayment || {};

BPayment.init = function () {
    if ($('.card-wrapper').length > 0) {
        new Card({form: '.payment-checkout-form', container: '.card-wrapper'});
    }
    $(document).on('change', '.js_payment_method', function () {
        $('.payment_collapse_wrap').removeClass('collapse').removeClass('show').removeClass('active');
    });

    $(document).on('click', '.payment-checkout-btn', function () {
        var _self = $(this);
        var form = _self.closest('form');
        _self.attr('disabled', 'disabled');
        var submitInitialText = _self.html();
        _self.html('<i class="fa fa-gear fa-spin"></i> Processing. Please wait...');
        if ($('input[name=payment_method]:checked').val() === 'stripe') {
            Stripe.setPublishableKey($('#payment-stripe-key').data('value'));
            Stripe.card.createToken(form, function (status, response) {
                if (response.error) {
                    Botble.showError(response.error.message);
                    _self.removeAttr('disabled');
                    _self.html(submitInitialText);
                } else {
                    form.append($('<input type="hidden" name="stripeToken">').val(response.id));
                    form.submit();
                }
            });
        } else {
            form.submit();
        }
    });
};

$(document).ready(function () {
    BPayment.init();
});
