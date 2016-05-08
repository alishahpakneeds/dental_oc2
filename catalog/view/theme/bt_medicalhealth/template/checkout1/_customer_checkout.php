<table>
    <tr>

        <td colspan="4">
            <?php
            $customer_types = array(
                "Pessoa Física", "Pessoa Jurídica"
            );
            $i = 0;
            $checkd = '';

            foreach ($customer_types as $type) {
                if (!empty($payment_customer_type)) {
                    if ($payment_customer_type == $type) {
                        $checkd = 'checked="checked"';
                    }
                } else {
                    $checkd = '';
                    if ($i == 0) {
                        $checkd = 'checked="checked"';
                    } else {
                        $checkd = '';
                    }
                }
                ?>
                <input type="radio" class="cusomer_type"  name="payment_customer_type" value="<?php echo $type ?>" <?php echo $checkd; ?> /> 
                <label><?php echo $type ?></label>

                <?php
                $i++;
            }
            $checkd = '';
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="4">

            <table class="customer" style="display:none" >
                <tr>
                    <td>
                        <h2><?php echo $txt_payment_heading_customer; ?></h2>

                    </td>

                </tr>
                <tr>

                    <td>
                        p<?php echo $txt_payment_cad_name; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_cad_name" id="payment_cad_name" value="<?php echo isset($payment_cad_name) ? $payment_cad_name : ""; ?>" />
                    </td>
                    <td>
                        <?php echo $txt_payment_cad_dob; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_cad_dob" id="payment_cad_dob"  value="<?php echo isset($payment_cad_dob) ? $payment_cad_dob : ""; ?>" />
                    </td>
                </tr>
                <tr>

                    <td>
                        <?php echo $txt_payment_cad_cpf; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_cad_cpf" id="payment_cad_cpf" value="<?php echo isset($payment_cad_cpf) ? $payment_cad_cpf : ""; ?>"  />
                    </td>
                    <td>
                        <?php echo $txt_payment_cad_rg; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_cad_rg" id="payment_cad_rg" value="<?php echo isset($payment_cad_rg) ? $payment_cad_rg : ""; ?>"/>
                    </td>
                </tr>
                <tr>

                    <td>
                        <?php echo $txt_payment_cad_telefone; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_cad_telefone" id="payment_cad_telefone" value="<?php echo isset($payment_cad_telefone) ? $payment_cad_telefone : ""; ?>"/>
                    </td>
                    <td>
                        <?php echo $txt_payment_cad_celular; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_cad_celular" id="payment_cad_celular" value="<?php echo isset($payment_cad_celular) ? $payment_cad_celular : ""; ?>" />
                    </td>
                </tr>
                <tr>

                    <td colspan="4">
                        <?php
                        $genders = array(
                            "Masculino", "Feminino"
                        );
                        foreach ($genders as $gend) {
                            $selected = "";
                            if (!empty($payment_cad_gender) && $payment_cad_gender == $gend) {
                                $selected = "checked='checked';";
                            }
                            ?>
                            <input type="radio"  name="payment_cad_gender" value="<?php echo $gend ?>" <?php echo $selected; ?> /> 
                            <label><?php echo $gend ?></label>

                            <?php
                        }
                        ?>

                    </td>

                </tr>
            </table>

            <table class="account" style="display:none">
                <tr>
                    <td>
                        <h2><?php echo $txt_payment_heading_account; ?></h2>

                    </td>

                </tr>
                <tr>

                    <td>
                        <?php echo $txt_payment_corop_name; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_corop_name" id="payment_corop_name" value="<?php echo isset($payment_corop_name) ? $payment_corop_name : ""; ?>" />
                    </td>
                    <td>
                        <?php echo $txt_payment_corop_trade_name; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_corop_trade_name" id="payment_corop_trade_name" value="<?php echo isset($payment_corop_trade_name) ? $payment_corop_trade_name : ""; ?>"/>
                    </td>
                </tr>
                <tr>

                    <td>
                        <?php echo $txt_payment_corop_cnpg; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_corop_cnpg" id="payment_corop_cnpg" value="<?php echo isset($payment_corop_cnpg) ? $payment_corop_cnpg : ""; ?>"  />
                    </td>
                    <td> 
                        <?php echo $txt_payment_corop_responsible_name; ?>
                    </td>
                    <td>
                        <input type="text" id="payment_corop_responsible_name" 
                               name="payment_corop_responsible_name" 
                               value="<?php echo isset($payment_corop_responsible_name) ? $payment_corop_responsible_name : ""; ?>"/>
                    </td>
                </tr>
                <tr>

                    <td>
                        <?php echo $txt_payment_corop_telefone; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_corop_telefone" 
                               id="payment_corop_telefone" 
                               value = "<?php echo isset($payment_corop_telefone) ? $payment_corop_telefone : ""; ?>"
                               />
                    </td>
                    <td>
                        <?php echo $txt_payment_corop_responsible_cell; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_corop_responsible_cell" 
                               id="payment_corop_responsible_cell" value = "<?php echo isset($payment_corop_responsible_cell) ? $payment_corop_responsible_cell : ""; ?>" />
                    </td>
                </tr>
                <tr>

                    <td>
                        <?php echo $txt_payment_corop_state_registration; ?>
                    </td>
                    <td>
                        <input type="text" name="payment_corop_state_registration" 
                               id="payment_corop_state_registration" value="<?php echo isset($payment_corop_state_registration) ? $payment_corop_state_registration : ""; ?>" />
                    </td>
                    <td>
                        <?php echo $txt_payment_corop_isento; ?>
                    </td>
                    <td>
                        <input type="checkbox" name="payment_corop_isento" id="payment_corop_isento"
                               <?php echo!empty($payment_corop_isento) ? "checked='checked'" : ""; ?>/>
                    </td>
                </tr>

            </table>

            <table>
                <tr>

                    <th colspan="4"><?php echo $txt_payment_heading_profession; ?></th>
                </tr>
                <tr>

                    <td colspan="4">
                        <?php
                        $profession_types = array(
                            "Odontologista", "Protético",
                            "Acadêmico",
                        );
                        $i = 0;
                        foreach ($profession_types as $type) {
                            if (!empty($payment_profession_type)) {
                                if($payment_profession_type == $type){
                                    $checkd = 'checked="checked"';
                                }
                                else {
                                    $checkd = '';
                                }
                                
                            } else {
                                if ($i == 0) {
                                    $checkd = 'checked="checked"';
                                } else {
                                    $checkd = '';
                                }
                            }
                            ?>
                            <input type="radio"  name="payment_profession_type" 
                                   value="<?php echo $type ?>" <?php echo $checkd; ?> /> 
                            <label><?php echo $type ?></label>

                            <?php
                            $i++;
                        }
                        ?>

                    </td>
                </tr>
                <tr class="od" style="display: none">

                    <td>
                        <?php echo $txt_payment_profession_cro; ?>
                    </td>
                    <td colspan="3"> 
                        <input type="text" id="payment_profession_cro" name="payment_profession_cro" 
                               value="<?php echo isset($payment_profession_cro) ? $payment_profession_cro : ""; ?>" />
                    </td>

                </tr>
                <tr class="pr" style="display: none">

                    <td>
                        <?php echo $txt_payment_profession_tdp; ?>
                    </td>
                    <td colspan="3"> 
                        <input type="text" id="payment_profession_tdp" 
                               name="payment_profession_tdp"
                               value="<?php echo isset($payment_profession_tdp) ? $payment_profession_tdp : ""; ?>" />
                    </td>

                </tr>
                <tr class="ac" style="display: none">
                    <td>
                        <?php echo $txt_payment_profession_matricula; ?>
                    </td>
                    <td colspan="3">
                        <input type="text" id="payment_profession_matricula" 
                               name="payment_profession_matricula" 
                               value="<?php echo isset($payment_profession_matricula) ? $payment_profession_matricula : ""; ?>" 
                               />
                    </td>

                </tr>
                <tr class="ac" style="display: none">
                    <td>
                        <?php echo $txt_payment_profession_ensino; ?>
                    <td colspan="3">
                        <input type="text" id="payment_profession_ensino" 
                               name="payment_profession_ensino"
                               value="<?php echo isset($payment_profession_ensino) ? $payment_profession_ensino : ""; ?>"
                               />
                    </td>
                </tr>
                <tr>

                    <td>
                        <?php echo $txt_payment_profession_graduacao; ?>
                    </td>
                    <td>
                        <?php
                        $prof_inst = array(
                            'Selecione',
                            'Superior Completo',
                            'Pós Graduação',
                            'Mestrado',
                            'Doutorado',
                        );
                        $i = 0;
                        ?>
                        <select id="payment_profession_graduacao" name="payment_profession_graduacao">
                            <?php
                            $checked = '';
                            foreach ($prof_inst as $val) {
                                if (isset($payment_profession_graduacao) && $val == $payment_profession_graduacao) {
                                    $checkd = 'selected="selected"';
                                } else {
                                    $checked = '';
                                }
                                echo "<option value='" . $val . "' $checkd>" . $val . "</option>";

                                $i++;
                            }
                            $checkd = '';
                            ?>
                        </select>

                    </td>
                    <td>
                        <?php echo $txt_payment_profession_instituica; ?>
                    </td>
                    <td>
                        <input type="text" id="payment_profession_instituica" 
                               name="payment_profession_instituica"
                               value="<?php echo isset($payment_profession_instituica) ? $payment_profession_instituica : ""; ?>"
                               />
                    </td>
                </tr>
                <tr class="area">

                    <td>
                        <?php echo $txt_payment_profession_atuacao; ?>
                    </td>
                    <td colspan="3">
                        <?php
                        $options_atuaca = array(
                            "Clínica", "Dentística",
                            "Endodontia", "Estética",
                            "Ortodondia", "Periodontia",
                            "Prótese", "Radiologia",
                        );
                        $checkd = '';

                        foreach ($options_atuaca as $opt) {
                            if (!empty($payment_profession_atuacao) && in_array($opt, $payment_profession_atuacao)) {
                                $checkd = 'checked="checked"';
                            } else {
                                $checkd = '';
                            }
                            ?>
                            <label><?php echo $opt; ?></label>    
                            <input type="checkbox" name="payment_profession_atuacao[]" value="<?php echo $opt; ?>" <?php echo $checkd; ?> />
                            <?php
                        }
                        ?>

                    </td>

                </tr>
                <tr class="">
                    <td>
                        <?php echo $txt_payment_news_letter; ?>
                    </td>
                    <td colspan="3">
                        <input type="checkbox" name="payment_news_letter" id="payment_news_letter" checked="checked" />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<script>
    $(function() {
        $(".cusomer_type").click(function() {
            if ($(this).is(':checked')) {
                if ($(this).val() == 'Pessoa Física') {
                    $(".customer").show();
                    $(".account").hide();
                }
                else if ($(this).val() == 'Pessoa Jurídica') {
                    $(".account").show();
                    $(".customer").hide();
                }
            }
        })
        $("input.cusomer_type[checked='checked']").trigger("click");

        $("input[name='payment_profession_type'] ").click(function() {
            $(".od").hide();
            $(".pr").hide();
            $(".ac").hide();
            $(".area").show();
            if ($(this).is(':checked')) {
                if ($(this).val() == 'Odontologista') {
                    $(".od").show();
                }
                else if ($(this).val() == 'Protético') {
                    $(".pr").show();
                }
                else if ($(this).val() == 'Acadêmico') {
                    $(".ac").show();
                    $(".area").hide();
                }
            }
            console.log($(this));
        })
        $("input[name='payment_profession_type'][checked='checked'] ").trigger("click");

        //MANAGING MASKS
        $("#payment_cad_telefone").mask({mask: "(##)########?#"});
        $("#payment_corop_telefone").mask({mask: "(##)########?#"});



        $('#cpf_cnpj').focus(function() {
            $("#cpf_cnpj").mask('destroy');
            $("#cpf_cnpj").val($("#cpf_cnpj").val().replace(/[^\d]/g, ''));
        });
        $('#payment_corop_cnpg').blur(function() {
            if ($.isNumeric($("#payment_corop_cnpg").val()) == true) {
                if ($("#payment_corop_cnpg").val().length == 11) {
                    $("#payment_corop_cnpg").mask({mask: "###.###.###-##"});
                } else if ($("#payment_corop_cnpg").val().length == 14) {
                    $("#payment_corop_cnpg").mask({mask: "##.###.###/####-##"});
                }
            } else if ($.isNumeric($("#payment_corop_cnpg").val().replace(/[^\d]/g, '')) == false) {
                $("#payment_corop_cnpg").mask('destroy');
                $("#payment_corop_cnpg").val('');
            }
        });
    })

    function manage_custom_field_errors(json_error) {
        var error_fields = ['payment_cad_cpf', 'payment_cad_name',
            'payment_cad_dob', 'payment_cad_rg', 'payment_corop_cnpg',
            'payment_corop_name', 'payment_corop_trade_name', 'payment_corop_cnpg',
            'payment_corop_responsible_name'
        ];
        console.log(json_error);
        $.each(error_fields, function(k, v) {
            console.log(v);
            if (typeof (json_error[v]) != "undefined") {
                $('#' + v).after('<span class="error">' + json_error[v] + '</span>');
            }
        })

    }
</script>    