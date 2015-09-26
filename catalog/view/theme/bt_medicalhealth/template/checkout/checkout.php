<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<script type="text/javascript">
    var loggin_in = '<?php echo $logged; ?>';</script>

<div id="content"><?php echo $content_top; ?>
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <h1 class="checkout_title"><?php echo $heading_title; ?></h1>
    <div class="checkout">

        <div class="step_container" style="">
            <div id="checkout">   
                <div class="step-title">
                    <?php echo $text_checkout_option_step; ?>
                </div>
                <div class="checkout-content"></div>
            </div>
            <div class="payment-address-step">   
                <div class="step-title ">
                    <?php echo $text_checkout_account_step; ?>
                </div>
                <div class="checkout-content"></div>
            </div>

        </div>
        <div class="step_container" style="">
            <div class="shipping-address-step">   
                <div class="step-title">
                    <?php echo $text_checkout_payment_address_step; ?>
                </div>
                <div class="checkout-content"></div>
            </div>
        </div>
        <div class="step_container" style="">
            <div class="shipping-method-step">   
                <div class="step-title">
                    <?php echo $text_checkout_shipping_address_step; ?>
                </div>
                <div class="checkout-content"></div>
            </div>
            <div >   
                <div class="step-title">
                    <?php echo $text_checkout_shipping_method_step; ?>
                </div>
                <div class="checkout-content"></div>
            </div>
            <div class="payment-method-step">   
                <div class="step-title">
                    <?php echo $text_checkout_payment_method_step; ?>
                </div>
                <div class="checkout-content"></div>
            </div>
            <div id="confirm">   
                <div class="step-title">
                    <?php echo $text_checkout_confirm_step; ?>
                </div>
                <div class="checkout-content"></div>
            </div>
        </div>
        <div class="clear"></div>


        <?php if (!$logged) { ?>
            <div id="payment-address">
                <div class="checkout-heading"><span><?php echo $text_checkout_account; ?></span></div>
                <div class="checkout-content"></div>
            </div>
        <?php } else { ?>
            <div id="payment-address">
                <div class="checkout-heading"><span><?php echo $text_checkout_payment_address; ?></span></div>
                <div class="checkout-content"></div>
            </div>
        <?php } ?>
        <?php if ($shipping_required) { ?>
            <div id="shipping-address">
                <div class="checkout-heading"><span><?php echo $text_checkout_shipping_address; ?></span></div>
                <div class="checkout-content"></div>
            </div>
            <div id="shipping-method">
                <div class="checkout-heading"><span><?php echo $text_checkout_shipping_method; ?></span></div>
                <div class="checkout-content"></div>
            </div>
        <?php } ?>
        <div id="payment-method">
            <div class="checkout-heading"><span><?php echo $text_checkout_payment_method; ?></span></div>
            <div class="checkout-content"></div>
        </div>
        <div >
            <div class="checkout-heading"><span><?php echo $text_checkout_confirm; ?></span></div>
            <div class="checkout-content"></div>
        </div>
    </div>
    <?php echo $content_bottom; ?></div>
<script type="text/javascript">
    var logged_in = '<?php echo $logged; ?>';
    var quickconfirm_in = '<?php echo isset($quickconfirm) ? 1 : 0; ?>';
    var shipping_required_in = '<?php echo $shipping_required; ?>';
    //checkout login
    function checkout_login() {
        $.ajax({
            url: 'index.php?route=checkout/login',
            dataType: 'html',
            success: function (html) {
                $('#checkout .checkout-content').html(html);
                $('#checkout .checkout-content').slideDown('slow');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function checkout_payment() {
        $.ajax({
            url: 'index.php?route=checkout/payment_address',
            dataType: 'html',
            success: function (html) {

                //$('.payment-address-step .checkout-content').html(html);
                //$('.payment-address-step .checkout-content').slideDown('slow');
                $(".payment-address-step").find("div.checkout-content").html(html);
                $(".payment-address-step").find("div.checkout-content").slideDown('slow');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function checkout_shipping() {
        $.ajax({
            url: 'index.php?route=checkout/shipping_address',
            dataType: 'html',
            success: function (html) {
                $('.shipping-address-step .checkout-content').html(html);
                $('.shipping-address-step .checkout-content').slideDown('slow');

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function checkout_payment_method() {
        $.ajax({
            url: 'index.php?route=checkout/payment_method',
            dataType: 'html',
            success: function (html) {
                $('.payment-method-step  .checkout-content').html(html);

                $('.payment-method-step  .checkout-content').slideDown('slow');

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function checkout_payment_address() {

        $.ajax({
            url: 'index.php?route=checkout/payment_address',
            dataType: 'html',
            success: function (html) {
                $('.payment-address-step .checkout-content').html(html);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    //===============================================

    function shipping_address_checkout() {
        $.ajax({
            url: 'index.php?route=checkout/shipping_address/validate',
            type: 'post',
            data: $('.shipping-address-step input[type=\'text\'], .shipping-address-step input[type=\'password\'],.shipping-address-step input[type=\'checkbox\']:checked, .shipping-address-step input[type=\'radio\']:checked, .shipping-address-step select'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-shipping-address').attr('disabled', true);
                $('#button-shipping-address').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-shipping-address').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .error').remove();
                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('.shipping-address-step .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
                        $('.warning').fadeIn('slow');
                    }

                    if (json['error']['firstname']) {
                        $('.shipping-address-step input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
                    }

                    if (json['error']['lastname']) {
                        $('.shipping-address-step input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
                    }

                    if (json['error']['email']) {
                        $('.shipping-address-step input[name=\'email\']').after('<span class="error">' + json['error']['email'] + '</span>');
                    }

                    if (json['error']['telephone']) {
                        $('.shipping-address-step input[name=\'telephone\']').after('<span class="error">' + json['error']['telephone'] + '</span>');
                    }

                    if (json['error']['address_1']) {
                        $('.shipping-address-step input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
                    }

                    if (json['error']['city']) {
                        $('.shipping-address-step input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
                    }

                    if (json['error']['postcode']) {
                        $('.shipping-address-step input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
                    }

                    if (json['error']['country']) {
                        $('.shipping-address-step select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
                    }

                    if (json['error']['zone']) {
                        $('.shipping-address-step select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
                    }
                } else {
                    $.ajax({
                        url: 'index.php?route=checkout/shipping_method',
                        dataType: 'html',
                        success: function (html) {
                            $('.shipping-method-step .checkout-content').html(html);
                            $('.shipping-address-step .checkout-content').slideUp('slow');
                            $('.shipping-method-step .checkout-content').slideDown('slow');
                            $('.shipping-address-step .checkout-heading a').remove();
                            $('.shipping-method-step .checkout-heading a').remove();
                            $('.payment-method-step  .checkout-heading a').remove();
                            $('.shipping-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                            $.ajax({
                                url: 'index.php?route=checkout/shipping_address',
                                dataType: 'html',
                                success: function (html) {
                                    $('.shipping-address-step .checkout-content').html(html);
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                    $.ajax({
                        url: 'index.php?route=checkout/payment_address',
                        dataType: 'html',
                        success: function (html) {
                            $('.payment-address-step .checkout-content').html(html);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function payment_address_checkout() {
        $.ajax({
            url: 'index.php?route=checkout/payment_address/validate',
            type: 'post',
            data: $('.payment-address-step input[type=\'text\'], .payment-address-step input[type=\'password\'], .payment-address-step input[type=\'checkbox\']:checked, .payment-address-step input[type=\'radio\']:checked, .payment-address-step input[type=\'hidden\'], .payment-address-step select'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-payment-address').attr('disabled', true);
                $('#button-payment-address').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-payment-address').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .error').remove();
                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('.payment-address-step .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
                        $('.warning').fadeIn('slow');
                    }

                    if (json['error']['firstname']) {
                        $('.payment-address-step input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
                    }

                    if (json['error']['lastname']) {
                        $('.payment-address-step input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
                    }

                    if (json['error']['telephone']) {
                        $('.payment-address-step input[name=\'telephone\']').after('<span class="error">' + json['error']['telephone'] + '</span>');
                    }

                    if (json['error']['company_id']) {
                        $('.payment-address-step input[name=\'company_id\']').after('<span class="error">' + json['error']['company_id'] + '</span>');
                    }

                    if (json['error']['tax_id']) {
                        $('.payment-address-step input[name=\'tax_id\']').after('<span class="error">' + json['error']['tax_id'] + '</span>');
                    }

                    if (json['error']['address_1']) {
                        $('.payment-address-step input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
                    }

                    if (json['error']['city']) {
                        $('.payment-address-step input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
                    }

                    if (json['error']['postcode']) {
                        $('.payment-address-step input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
                    }

                    if (json['error']['country']) {
                        $('.payment-address-step select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
                    }

                    if (json['error']['zone']) {
                        $('.payment-address-step select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
                    }
                    if (typeof manage_custom_field_errors == 'function') {
                        manage_custom_field_errors(json['error']);
                    }
                } else {
                    if (shipping_required_in === '1') {
                        checkout_shipping();
                    }
                    else {
                        checkout_payment_method();
                    }

                    checkout_payment_address()
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function payment_method_checkout() {
        $.ajax({
            url: 'index.php?route=checkout/payment_method/validate',
            type: 'post',
            data: $('.payment-method-step  input[type=\'radio\']:checked, .payment-method-step  input[type=\'checkbox\']:checked, .payment-method-step  textarea'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-payment-method').attr('disabled', true);
                $('#button-payment-method').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-payment-method').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .error').remove();
                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('.payment-method-step  .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
                        $('.warning').fadeIn('slow');
                    }
                } else {
                    checkout_confirm();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function shipping_method_checkout() {
        $.ajax({
            url: 'index.php?route=checkout/shipping_method/validate',
            type: 'post',
            data: $('.shipping-method-step input[type=\'radio\']:checked, .shipping-method-step textarea'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-shipping-method').attr('disabled', true);
                $('#button-shipping-method').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-shipping-method').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .error').remove();
                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('.shipping-method-step .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
                        $('.warning').fadeIn('slow');
                    }
                } else {
                    $.ajax({
                        url: 'index.php?route=checkout/payment_method',
                        dataType: 'html',
                        success: function (html) {
                            $(' .checkout-content').html(html);
                            $('.shipping-method-step .checkout-content').slideUp('slow');
                            $('.payment-method-step  .checkout-content').slideDown('slow');
                            $('.shipping-method-step .checkout-heading a').remove();
                            $('.payment-method-step  .checkout-heading a').remove();
                            $('.shipping-method-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function checkout_shipping_method() {
        $.ajax({
            url: 'index.php?route=checkout/shipping_method',
            dataType: 'html',
            success: function (html) {
                $('.shipping-method-step .checkout-content').html(html);
                $('.shipping-method-step .checkout-content').slideDown('slow');


//                $.ajax({
//                    url: 'index.php?route=checkout/shipping_address',
//                    dataType: 'html',
//                    success: function (html) {
//                        $('.shipping-address-step .checkout-content').html(html);
//                    },
//                    error: function (xhr, ajaxOptions, thrownError) {
//                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
//                    }
//                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function checkout_confirm(is_ajax) {
        if (is_ajax == '1') {
            url_checkout = 'index.php?route=checkout/confirminit&is_ajax=' + is_ajax;
        }
        else {
            url_checkout = 'index.php?route=checkout/confirm';
        }

        $.ajax({
            url: url_checkout,
            dataType: 'html',
            success: function (html) {
                $('#confirm .checkout-content').html(html);
                $('#confirm .checkout-content').slideDown('slow');

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    $('#checkout .checkout-content input[name=\'account\']').live('change', function () {
        if ($(this).attr('value') == 'register') {
            $('.payment-address-step .checkout-heading span').html('<?php echo $text_checkout_account; ?>');
        } else {
            $('.payment-address-step .checkout-heading span').html('<?php echo $text_checkout_payment_address; ?>');
        }
    });
    $('.checkout-heading a').live('click', function () {
        $('.checkout-content').slideUp('slow');
        $(this).parent().parent().find('.checkout-content').slideDown('slow');
    });
    //==============================================
    $(document).ready(function () {
        if (logged_in !== "1") {
            if (quickconfirm_in === "1") {
                quickConfirm();
            }
            else {
                checkout_login();


            }
        }
        else {
            if (quickconfirm_in === "1") {
                quickConfirm();
            }
            else {
                checkout_payment();
                checkout_shipping();
                checkout_shipping_method();
                checkout_payment_method();
                checkout_confirm('1');
            }
        }
    });

//==========End payment address=============
// Checkout
    function button_account_click() {
        $.ajax({
            url: 'index.php?route=checkout/' + $('input[name=\'account\']:checked').attr('value'),
            dataType: 'html',
            beforeSend: function () {
                $('#button-account').attr('disabled', true);
                $('#button-account').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-account').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (html) {
                $('.warning, .error').remove();
                $('.payment-address-step .checkout-content').html(html);
                $('#checkout .checkout-content').slideUp('slow');
                $('.payment-address-step .checkout-content').slideDown('slow');
                $('.checkout-heading a').remove();
                $('#checkout .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function button_login_click() {
        $.ajax({
            url: 'index.php?route=checkout/login/validate',
            type: 'post',
            data: $('#checkout #login :input'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-login').attr('disabled', true);
                $('#button-login').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-login').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .error').remove();
                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    $('#checkout .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
                    $('.warning').fadeIn('slow');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    $('#button-account').live('click', function () {
        button_account_click();
    });
// Login
    $('#button-login').live('click', function () {
        button_login_click();
    });
// Register
    $('#button-register').live('click', function () {
        $.ajax({
            url: 'index.php?route=checkout/register/validate',
            type: 'post',
            data: $('.payment-address-step input[type=\'text\'], .payment-address-step input[type=\'password\'], .payment-address-step input[type=\'checkbox\']:checked, .payment-address-step input[type=\'radio\']:checked, .payment-address-step input[type=\'hidden\'], .payment-address-step select'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-register').attr('disabled', true);
                $('#button-register').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-register').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .error').remove();
                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('.payment-address-step .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
                        $('.warning').fadeIn('slow');
                    }

                    if (json['error']['firstname']) {
                        $('.payment-address-step input[name=\'firstname\'] + br').after('<span class="error">' + json['error']['firstname'] + '</span>');
                    }

                    if (json['error']['lastname']) {
                        $('.payment-address-step input[name=\'lastname\'] + br').after('<span class="error">' + json['error']['lastname'] + '</span>');
                    }

                    if (json['error']['email']) {
                        $('.payment-address-step input[name=\'email\'] + br').after('<span class="error">' + json['error']['email'] + '</span>');
                    }

                    if (json['error']['telephone']) {
                        $('.payment-address-step input[name=\'telephone\'] + br').after('<span class="error">' + json['error']['telephone'] + '</span>');
                    }

                    if (json['error']['company_id']) {
                        $('.payment-address-step input[name=\'company_id\'] + br').after('<span class="error">' + json['error']['company_id'] + '</span>');
                    }

                    if (json['error']['tax_id']) {
                        $('.payment-address-step input[name=\'tax_id\'] + br').after('<span class="error">' + json['error']['tax_id'] + '</span>');
                    }

                    if (json['error']['address_1']) {
                        $('.payment-address-step input[name=\'address_1\'] + br').after('<span class="error">' + json['error']['address_1'] + '</span>');
                    }

                    if (json['error']['city']) {
                        $('.payment-address-step input[name=\'city\'] + br').after('<span class="error">' + json['error']['city'] + '</span>');
                    }

                    if (json['error']['postcode']) {
                        $('.payment-address-step input[name=\'postcode\'] + br').after('<span class="error">' + json['error']['postcode'] + '</span>');
                    }

                    if (json['error']['country']) {
                        $('.payment-address-step select[name=\'country_id\'] + br').after('<span class="error">' + json['error']['country'] + '</span>');
                    }

                    if (json['error']['zone']) {
                        $('.payment-address-step select[name=\'zone_id\'] + br').after('<span class="error">' + json['error']['zone'] + '</span>');
                    }

                    if (json['error']['password']) {
                        $('.payment-address-step input[name=\'password\'] + br').after('<span class="error">' + json['error']['password'] + '</span>');
                    }

                    if (json['error']['confirm']) {
                        $('.payment-address-step input[name=\'confirm\'] + br').after('<span class="error">' + json['error']['confirm'] + '</span>');
                    }


                } else {
                    if (shipping_required_in) {
                        var shipping_address = $('.payment-address-step input[name=\'shipping_address\']:checked').attr('value');
                        if (shipping_address) {
                            checkout_shipping_method()
                        } else {
                            $.ajax({
                                url: 'index.php?route=checkout/shipping_address',
                                dataType: 'html',
                                success: function (html) {
                                    $('.shipping-address-step .checkout-content').html(html);
                                    $('.payment-address-step .checkout-content').slideUp('slow');
                                    $('.shipping-address-step .checkout-content').slideDown('slow');
                                    $('#checkout .checkout-heading a').remove();
                                    $('.payment-address-step .checkout-heading a').remove();
                                    $('.shipping-address-step .checkout-heading a').remove();
                                    $('.shipping-method-step .checkout-heading a').remove();
                                    $('.payment-method-step  .checkout-heading a').remove();
                                    $('.payment-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        }
                    } else {
                        $.ajax({
                            url: 'index.php?route=checkout/payment_method',
                            dataType: 'html',
                            success: function (html) {
                                $('.payment-method-step  .checkout-content').html(html);
                                $('.payment-address-step .checkout-content').slideUp('slow');
                                $('.payment-method-step  .checkout-content').slideDown('slow');
                                $('#checkout .checkout-heading a').remove();
                                $('.payment-address-step .checkout-heading a').remove();
                                $('.payment-method-step  .checkout-heading a').remove();
                                $('.payment-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }
                    $.ajax({
                        url: 'index.php?route=checkout/payment_address',
                        dataType: 'html',
                        success: function (html) {
                            $('.payment-address-step .checkout-content').html(html);
                            $('.payment-address-step .checkout-heading span').html('<?php echo $text_checkout_payment_address; ?>');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
// Payment Address	
    $('#button-payment-address').live('click', function () {
        payment_address_checkout();
    });
// Shipping Address			
    $('#button-shipping-address').live('click', function () {
        shipping_address_checkout();
    });
// Guest
    $('#button-guest').live('click', function () {
        $.ajax({
            url: 'index.php?route=checkout/guest/validate',
            type: 'post',
            data: $('.payment-address-step input[type=\'text\'], .payment-address-step input[type=\'checkbox\']:checked, .payment-address-step select'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-guest').attr('disabled', true);
                $('#button-guest').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-guest').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .error').remove();
                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('.payment-address-step .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
                        $('.warning').fadeIn('slow');
                    }

                    if (json['error']['firstname']) {
                        $('.payment-address-step input[name=\'firstname\'] + br').after('<span class="error">' + json['error']['firstname'] + '</span>');
                    }

                    if (json['error']['lastname']) {
                        $('.payment-address-step input[name=\'lastname\'] + br').after('<span class="error">' + json['error']['lastname'] + '</span>');
                    }

                    if (json['error']['email']) {
                        $('.payment-address-step input[name=\'email\'] + br').after('<span class="error">' + json['error']['email'] + '</span>');
                    }

                    if (json['error']['telephone']) {
                        $('.payment-address-step input[name=\'telephone\'] + br').after('<span class="error">' + json['error']['telephone'] + '</span>');
                    }

                    if (json['error']['company_id']) {
                        $('.payment-address-step input[name=\'company_id\'] + br').after('<span class="error">' + json['error']['company_id'] + '</span>');
                    }

                    if (json['error']['tax_id']) {
                        $('.payment-address-step input[name=\'tax_id\'] + br').after('<span class="error">' + json['error']['tax_id'] + '</span>');
                    }

                    if (json['error']['address_1']) {
                        $('.payment-address-step input[name=\'address_1\'] + br').after('<span class="error">' + json['error']['address_1'] + '</span>');
                    }

                    if (json['error']['city']) {
                        $('.payment-address-step input[name=\'city\'] + br').after('<span class="error">' + json['error']['city'] + '</span>');
                    }

                    if (json['error']['postcode']) {
                        $('.payment-address-step input[name=\'postcode\'] + br').after('<span class="error">' + json['error']['postcode'] + '</span>');
                    }

                    if (json['error']['country']) {
                        $('.payment-address-step select[name=\'country_id\'] + br').after('<span class="error">' + json['error']['country'] + '</span>');
                    }

                    if (json['error']['zone']) {
                        $('.payment-address-step select[name=\'zone_id\'] + br').after('<span class="error">' + json['error']['zone'] + '</span>');
                    }
                } else {
<?php if ($shipping_required) { ?>
                        var shipping_address = $('.payment-address-step input[name=\'shipping_address\']:checked').attr('value');
                        if (shipping_address) {
                            $.ajax({
                                url: 'index.php?route=checkout/shipping_method',
                                dataType: 'html',
                                success: function (html) {
                                    $('.shipping-method-step .checkout-content').html(html);
                                    $('.payment-address-step .checkout-content').slideUp('slow');
                                    $('.shipping-method-step .checkout-content').slideDown('slow');
                                    $('.payment-address-step .checkout-heading a').remove();
                                    $('.shipping-address-step .checkout-heading a').remove();
                                    $('.shipping-method-step .checkout-heading a').remove();
                                    $('.payment-method-step  .checkout-heading a').remove();
                                    $('.payment-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                                    $('.shipping-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                                    $.ajax({
                                        url: 'index.php?route=checkout/guest_shipping',
                                        dataType: 'html',
                                        success: function (html) {
                                            $('.shipping-address-step .checkout-content').html(html);
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                        }
                                    });
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        } else {
                            $.ajax({
                                url: 'index.php?route=checkout/guest_shipping',
                                dataType: 'html',
                                success: function (html) {
                                    $('.shipping-address-step .checkout-content').html(html);
                                    $('.payment-address-step .checkout-content').slideUp('slow');
                                    $('.shipping-address-step .checkout-content').slideDown('slow');
                                    $('.payment-address-step .checkout-heading a').remove();
                                    $('.shipping-address-step .checkout-heading a').remove();
                                    $('.shipping-method-step .checkout-heading a').remove();
                                    $('.payment-method-step  .checkout-heading a').remove();
                                    $('.payment-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        }
<?php } else { ?>
                        $.ajax({
                            url: 'index.php?route=checkout/payment_method',
                            dataType: 'html',
                            success: function (html) {
                                $('.payment-method-step  .checkout-content').html(html);
                                $('.payment-address-step .checkout-content').slideUp('slow');
                                $('.payment-method-step  .checkout-content').slideDown('slow');
                                $('.payment-address-step .checkout-heading a').remove();
                                $('.payment-method-step  .checkout-heading a').remove();
                                $('.payment-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
<?php } ?>
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
// Guest Shipping
    $('#button-guest-shipping').live('click', function () {
        $.ajax({
            url: 'index.php?route=checkout/guest_shipping/validate',
            type: 'post',
            data: $('.shipping-address-step input[type=\'text\'], .shipping-address-step select'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-guest-shipping').attr('disabled', true);
                $('#button-guest-shipping').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-guest-shipping').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .error').remove();
                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('.shipping-address-step .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
                        $('.warning').fadeIn('slow');
                    }

                    if (json['error']['firstname']) {
                        $('.shipping-address-step input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
                    }

                    if (json['error']['lastname']) {
                        $('.shipping-address-step input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
                    }

                    if (json['error']['address_1']) {
                        $('.shipping-address-step input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
                    }

                    if (json['error']['city']) {
                        $('.shipping-address-step input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
                    }

                    if (json['error']['postcode']) {
                        $('.shipping-address-step input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
                    }

                    if (json['error']['country']) {
                        $('.shipping-address-step select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
                    }

                    if (json['error']['zone']) {
                        $('.shipping-address-step select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
                    }
                } else {
                    $.ajax({
                        url: 'index.php?route=checkout/shipping_method',
                        dataType: 'html',
                        success: function (html) {
                            $('.shipping-method-step .checkout-content').html(html);
                            $('.shipping-address-step .checkout-content').slideUp('slow');
                            $('.shipping-method-step .checkout-content').slideDown('slow');
                            $('.shipping-address-step .checkout-heading a').remove();
                            $('.shipping-method-step .checkout-heading a').remove();
                            $('.payment-method-step  .checkout-heading a').remove();
                            $('.shipping-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
    $('#button-shipping-method').live('click', function () {
        shipping_method_checkout();
    });
    $('#button-payment-method').live('click', function () {
        payment_method_checkout();
    });
    function quickConfirm(module) {
        $.ajax({
            url: 'index.php?route=checkout/confirm',
            dataType: 'html',
            success: function (html) {
                $('#confirm .checkout-content').html(html);
                $('#confirm .checkout-content').slideDown('slow');
                $('.checkout-heading a').remove();
                $('#checkout .checkout-heading a').remove();
                $('#checkout .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                $('.shipping-address-step .checkout-heading a').remove();
                $('.shipping-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                $('.shipping-method-step .checkout-heading a').remove();
                $('.shipping-method-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                $('.payment-address-step .checkout-heading a').remove();
                $('.payment-address-step .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                $('.payment-method-step  .checkout-heading a').remove();
                $('.payment-method-step  .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
//--></script> 
<?php echo $footer; ?>