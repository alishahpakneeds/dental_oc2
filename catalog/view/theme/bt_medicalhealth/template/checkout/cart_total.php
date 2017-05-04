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
        <?php
        //total class
        foreach ($totals as $total) {
            $css_tota_class = "";
            if ($total['code'] == 'sub_total') {
                $css_tota_class = " sub_total_payment";
            } else if ($total['code'] == 'shipping') {
                $css_tota_class = " shipping_payment";
            } else if ($total['code'] == 'total') {
                $css_tota_class = " final_total_payment";
            }
            ?>
            <tr>
                <td class="model"></td>
                <td colspan="2" class="price<?php echo ($total == end($totals) ? ' last' : ''); ?>"><b><?php echo $total['title']; ?>:</b></td>
                <td class="total<?php
                    echo ($total == end($totals) ? ' last' : '');
                    echo $css_tota_class;
                    ?>"><?php echo $total['text']; ?></td>
            </tr>
<?php } ?>
    </tfoot>
</table>