<?php

class ControllerCheckoutConfirminit extends Controller {

    public function index() {



        // Validate if payment address has been set.
        $this->load->model('account/address');

        if ($this->cart->hasShipping()) {
            // Validate if shipping address has been set.		
            $this->load->model('account/address');

            if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {
                $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
            } 

            
        } else {
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
        }


        // Validate minimum quantity requirments.			
        $products = $this->cart->getProducts();

        foreach ($products as $product) {
            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $redirect = $this->url->link('checkout/cart');

                break;
            }
        }

        if ($this->request->get["is_ajax"] == "1") {
            $redirect = "";
        }

        if (!$redirect) {
            $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();

            $this->load->model('setting/extension');

            $sort_order = array();

            $results = $this->model_setting_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('total/' . $result['code']);

                    $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                }
            }

            $sort_order = array();

            foreach ($total_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $total_data);

            $this->language->load('checkout/checkout');

            $data = array();

            $data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
            $data['store_id'] = $this->config->get('config_store_id');
            $data['store_name'] = $this->config->get('config_name');

            if ($data['store_id']) {
                $data['store_url'] = $this->config->get('config_url');
            } else {
                $data['store_url'] = HTTP_SERVER;
            }



            $product_data = array();


            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();
//                echo "<pre>";
//                    print_r($product['option']);
//                echo "</pre>";
//                echo "----------------";
                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['option_value'];
                    } else {
                        $value = $this->encryption->decrypt($option['option_value']);
                    }

                    $option_data[] = array(
                        'product_option_id' => $option['product_option_id'],
                        'product_option_value_id' => $option['product_option_value_id'],
                        'option_id' => $option['option_id'],
                        'option_value_id' => $option['option_value_id'],
                        'name' => $option['name'],
                        'value' => $value,
                        'type' => $option['type']
                    );
                }
                if (count($product['conf_options']) > 0) {

                    foreach ($product['conf_options'] as $key => $conf) {
                        $table = $key;
                        if ($key == 'quantitdy') {
                            $table = 'quantity';
                        }

                        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "conf_product_" . $table . " WHERE id = " . (int) $conf);
                        $option_data[] = array(
                            'name' => ucfirst($key),
                            'value' => $query->row['value'],
                            'product_option_id' => $query->row['id'],
                            'product_option_value_id' => $query->row['id'],
                            'option_id' => $query->row['id'],
                            'option_value_id' => $query->row['id'],
                            'type' => $query->row['id']
                        );
                    }
                }



                $product_data[] = array(
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => $option_data,
                    'download' => $product['download'],
                    'quantity' => $product['quantity'],
                    'subtract' => $product['subtract'],
                    'price' => $product['price'],
                    'total' => $product['total'],
                    'tax' => $this->tax->getTax($product['price'], $product['tax_class_id']),
                    'reward' => $product['reward']
                );
            }


            // Gift Voucher
            $voucher_data = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $voucher_data[] = array(
                        'description' => $voucher['description'],
                        'code' => substr(md5(mt_rand()), 0, 10),
                        'to_name' => $voucher['to_name'],
                        'to_email' => $voucher['to_email'],
                        'from_name' => $voucher['from_name'],
                        'from_email' => $voucher['from_email'],
                        'voucher_theme_id' => $voucher['voucher_theme_id'],
                        'message' => $voucher['message'],
                        'amount' => $voucher['amount']
                    );
                }
            }

            $data['products'] = $product_data;
            $data['vouchers'] = $voucher_data;
            $data['totals'] = $total_data;

            $data['total'] = $total;



            $data['language_id'] = $this->config->get('config_language_id');
            $data['currency_id'] = $this->currency->getId();
            $data['currency_code'] = $this->currency->getCode();
            $data['currency_value'] = $this->currency->getValue($this->currency->getCode());
            $data['ip'] = $this->request->server['REMOTE_ADDR'];

            if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                $data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                $data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
            } else {
                $data['forwarded_ip'] = '';
            }

            if (isset($this->request->server['HTTP_USER_AGENT'])) {
                $data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
            } else {
                $data['user_agent'] = '';
            }

            if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                $data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
            } else {
                $data['accept_language'] = '';
            }

            $this->load->model('checkout/order');



            $this->data['column_name'] = $this->language->get('column_name');
            $this->data['column_model'] = $this->language->get('column_model');
            $this->data['column_quantity'] = $this->language->get('column_quantity');
            $this->data['column_price'] = $this->language->get('column_price');
            $this->data['column_total'] = $this->language->get('column_total');

            $this->data['text_recurring_item'] = $this->language->get('text_recurring_item');
            $this->data['text_payment_profile'] = $this->language->get('text_payment_profile');

            $this->data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();

                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['option_value'];
                    } else {
                        $filename = $this->encryption->decrypt($option['option_value']);

                        $value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
                    }

                    $option_data[] = array(
                        'name' => $option['name'],
                        'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                    );
                }

                if (isset($option['conf_options']) && count($option['conf_options']) > 0) {
                    //this variable will be used to insert in database as order 
                    // conf options
                    $conf_options = array();
                    $conf_id = 0;
                    foreach ($product['conf_options'] as $key => $conf) {
                        $table = $key;

                        if ($key == 'quantitdy') {
                            $table = 'quantity';
                        }
                        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "conf_product_" . $key . " WHERE id = " . (int) $conf);
                        $option_data[] = array(
                            'name' => ucfirst($key),
                            'value' => $query->row['value'],
                        );
                        $conf_options[$key] = array(
                            'name' => ucfirst($key),
                            'value' => $query->row['value'],
                            'id' => $query->row['id'],
                        );
                    }

                    $this->addOrderConfiguration($product, $conf_options, $conf_id);
                }



                $profile_description = '';

                if ($product['recurring']) {
                    $frequencies = array(
                        'day' => $this->language->get('text_day'),
                        'week' => $this->language->get('text_week'),
                        'semi_month' => $this->language->get('text_semi_month'),
                        'month' => $this->language->get('text_month'),
                        'year' => $this->language->get('text_year'),
                    );

                    if ($product['recurring_trial']) {
                        $recurring_price = $this->currency->format($this->tax->calculate($product['recurring_trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')));
                        $profile_description = sprintf($this->language->get('text_trial_description'), $recurring_price, $product['recurring_trial_cycle'], $frequencies[$product['recurring_trial_frequency']], $product['recurring_trial_duration']) . ' ';
                    }

                    $recurring_price = $this->currency->format($this->tax->calculate($product['recurring_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')));

                    if ($product['recurring_duration']) {
                        $profile_description .= sprintf($this->language->get('text_payment_description'), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration']);
                    } else {
                        $profile_description .= sprintf($this->language->get('text_payment_until_canceled_description'), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration']);
                    }
                }

                $this->data['products'][] = array(
                    'key' => $product['key'],
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => $option_data,
                    'quantity' => $product['quantity'],
                    'subtract' => $product['subtract'],
                    'price' => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))),
                    'total' => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']),
                    'href' => $this->url->link('product/product', 'product_id=' . $product['product_id']),
                    'recurring' => $product['recurring'],
                    'profile_name' => $product['profile_name'],
                    'profile_description' => $profile_description,
                );
            }

            // Gift Voucher
            $this->data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $this->data['vouchers'][] = array(
                        'description' => $voucher['description'],
                        'amount' => $this->currency->format($voucher['amount'])
                    );
                }
            }

            $this->data['totals'] = $total_data;
        } else {
            $this->data['redirect'] = $redirect;
        }
        $this->data['logged'] = '';
        if ($this->customer->isLogged()) {
            $this->data['logged'] = '1';
        }




        if ($this->request->get["is_ajax"] == "1") {
            unset($this->data['redirect']);
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm.php')) {
            $this->template = $this->config->get('config_template') . '/template/checkout/confirm.php';
        } else {
            $this->template = 'default/template/checkout/confirm.tpl';
        }

        $this->response->setOutput($this->render());
    }

    public function addOrderConfiguration($product, $conf_options, $conf_id = 0) {
        $sql = "Select * FROM " . DB_PREFIX . "order_product_config_options WHERE product_id = " . (int) ($product['product_id']) . " AND order_id=" . (int) $this->session->data['order_id'] . " ";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
            if (isset($conf_options['arcade'])) {
                $columns [] = "arcade = '" . (int) $conf_options['arcade']['id'] . "'";
            }
            if (isset($conf_options['tamanho'])) {
                $columns [] = "tamanho = '" . (int) $conf_options['tamanho']['id'] . "'";
            }
            if (isset($conf_options['cor'])) {
                $columns [] = "cor = '" . (int) $conf_options['cor']['id'] . "'";
            }
            if (isset($conf_options['quantitdy'])) {
                $columns [] = "quantitdy = '" . (int) $conf_options['quantitdy']['id'] . "'";
            }
            if (isset($conf_id) && $conf_id != 0) {
                $columns [] = "conf_id = '" . (int) $conf_id . "'";
            }



            $columns [] = "product_id = '" . (int) $product['product_id'] . "'";
            $columns [] = "order_id = '" . (int) $this->session->data['order_id'] . "'";
            $columns [] = "date_added = '" . date("Y-m-d h:i:s") . "'";
            $columns [] = "date_modified = '" . date("Y-m-d h:i:s") . "'";

            $sql = "INSERT INTO " . DB_PREFIX . "order_product_config_options SET " . implode($columns, ",");

            $this->db->query($sql);
        }
    }

}

?>