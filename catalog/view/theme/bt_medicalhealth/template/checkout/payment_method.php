<?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if (!isset($redirect)) { ?>
    <div class="checkout-product" >
        <table>
            <thead>
                <tr>
                    <td class="name"><?php echo $column_name; ?></td>
                    <td class="model"><?php echo $column_model; ?></td>
                    <td class="quantity"><?php echo $column_quantity; ?></td>
                    <td class="price"><?php echo $column_price; ?></td>
                    <td class="total"><?php echo $column_total; ?></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>  
                    <?php if ($product['recurring']): ?>
                        <tr>
                            <td colspan="6" style="border:none;"><image src="catalog/view/theme/default/image/reorder.png" alt="" title="" style="float:left;" /><span style="float:left;line-height:18px; margin-left:10px;"> 
                                    <strong><?php echo $text_recurring_item ?></strong>
                                    <?php echo $product['profile_description'] ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                            <?php foreach ($product['option'] as $option) { ?>
                                <br />
                                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                            <?php } ?>
                            <?php if ($product['recurring']): ?>
                                <br />
                                &nbsp;<small><?php echo $text_payment_profile ?>: <?php echo $product['profile_name'] ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="model"><?php echo $product['model']; ?></td>
                        <td class="quantity"><?php echo $product['quantity']; ?></td>
                        <td class="price"><?php echo $product['price']; ?></td>
                        <td class="total"><?php echo $product['total']; ?></td>
                    </tr>
                <?php } ?>
                <?php foreach ($vouchers as $voucher) { ?>
                    <tr>
                        <td class="name"><?php echo $voucher['description']; ?></td>
                        <td class="model"></td>
                        <td class="quantity">1</td>
                        <td class="price"><?php echo $voucher['amount']; ?></td>
                        <td class="total"><?php echo $voucher['amount']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <?php foreach ($totals as $total) { ?>
                    <tr>
                        <td class="model"></td>
                        <td colspan="2" class="price<?php echo ($total == end($totals) ? ' last' : ''); ?>"><b><?php echo $total['title']; ?>:</b></td>
                        <td class="total<?php echo ($total == end($totals) ? ' last' : ''); ?>"><?php echo $total['text']; ?></td>
                    </tr>
                <?php } ?>
            </tfoot>
        </table>
    </div>
<?php } ?>
<?php if ($payment_methods) { ?>
    <p><?php echo $text_payment_method; ?></p>
    <table class="radio">
        <?php foreach ($payment_methods as $payment_method) { ?>
            <tr class="highlight">
                <td><?php if ($payment_method['code'] == $code || !$code) { ?>
                        <?php $code = $payment_method['code']; ?>
                        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" checked="checked" />
                    <?php } else { ?>
                        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" />
                    <?php } ?></td>
                <td><label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label></td>
            </tr>
        <?php } ?>
    </table>
    <br />
<?php } ?>
<b><?php echo $text_comments; ?></b>
<textarea name="comment" rows="8" style="width: 98%;"><?php echo $comment; ?></textarea>
<br />
<br />
<?php if ($text_agree) { ?>
    <div class="buttons">
        <div class="left">
            <?php if ($agree) { ?>
                <input type="checkbox" name="agree" value="1" checked="checked" />
            <?php } else { ?>
                <input type="checkbox" name="agree" value="1" />
            <?php } ?>&nbsp;&nbsp;<?php echo $text_agree; ?> 

        </div>
    </div>
    <div class="buttons hidden">
        <div class="left">

            <span class="orange_button"><input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="button" /></span>
        </div>
    </div>
<?php } else { ?>
    <div class="buttons hidden">
        <div class="left">
            <span class="orange_button"><input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="button" /></span>
        </div>
    </div>
<?php } ?>

<script type="text/javascript"><!--
function get_Width_Height() {
        var array = new Array();
        if (getWidthBrowser() > 767) {
            array[0] = 640;
            array[1] = 480;
        } else if (getWidthBrowser() < 767 && getWidthBrowser() > 480) {
            array[0] = 450;
            array[1] = 350;
        } else {
            array[0] = 300;
            array[1] = 300;
        }
        return array;
    }
    $('.colorbox').colorbox({
        width: get_Width_Height()[0],
        height: get_Width_Height()[1]
    });
//--></script> 