$(function() {

    var owner = $('#owner');
    var cardNumber = $('#cardNumber');
    var cardNumberField = $('#card-number-field');
    var CVV = $("#cvv");
    var mastercard = $("#mastercard");
    var confirmButton = $('#confirm-purchase');
    var visa = $("#visa");
    var amex = $("#amex");

    // Use the payform library to format and validate
    // the payment fields.

    cardNumber.payform('formatCardNumber');
    CVV.payform('formatCardCVC');


    cardNumber.keyup(function() {

        amex.removeClass('transparent');
        visa.removeClass('transparent');
        mastercard.removeClass('transparent');

        if ($.payform.validateCardNumber(cardNumber.val()) == false) {
            cardNumberField.addClass('has-error');
        } else {
            cardNumberField.removeClass('has-error');
            cardNumberField.addClass('has-success');
        }

        if ($.payform.parseCardType(cardNumber.val()) == 'visa') {
            mastercard.addClass('transparent');
            amex.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'amex') {
            mastercard.addClass('transparent');
            visa.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') {
            amex.addClass('transparent');
            visa.addClass('transparent');
        }
    });

    confirmButton.click(function(e) {

        e.preventDefault();

        var isCardValid = $.payform.validateCardNumber(cardNumber.val());
        var isCvvValid = $.payform.validateCardCVC(CVV.val());

        if(owner.val().length < 5){
            alert("Wrong owner name");
        } else if (!isCardValid) {
            alert("Wrong card number");
        } else if (!isCvvValid) {
            alert("Wrong CVV");
        } else {
            // Everything is correct. Add your form submission code here.
            if (!$('#payment-form').data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey('pk_test_OKWnvvdkVhlMhI7LjnBiu9XN');
                Stripe.createToken({
					name: owner.val(),
                    number: $('#cardNumber').val(),
                    cvc: $('#cvv').val(),
                    exp_month: $('#expirationMonth').find(':selected').val(),
                    exp_year: $('#expirationYear').find(':selected').val()
                }, function(status, response) {
                    $('.fa-spinner').removeClass('hide');
                    if (response.error) {
                        alert(response.error.message);
                        $('.fa-spinner').addClass('hide');
                    } else {
                        // token contains id, last4, and card type
                        var token = response['id'];
                        // insert the token into the form so it gets submitted to the server
                        $('#payment-form').find('input[type=text]').empty();
                        $('#payment-form').append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                        $.post('/pay', $('#payment-form').serialize(), function(res) {
                            if (res.success) {
                                window.location = '/thanks/' + res.order_id;
                            } else {
                                alert(res.message);
                                $('.fa-spinner').hide();
                            }
                        });
                    }
                });
            }
        }
    });
});
