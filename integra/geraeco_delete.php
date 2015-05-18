<!DOCTYPE HTML>
<?php
/*
 * Esta página foi desenvolvida por Miwana Tecnologia da Informação Ltda.
 * www.miwana.com.br
 * miwana@miwana.com.br
 * 
 * Importa os dados do Arquivo SIDICOM no ECOMMERCE 
 */
$test_s = "CER S-BASE SBA1 (10G)";
function delete_related_products_tables($conexao, $product_id) {
        $sql = 'DELETE FROM '.$db_prefix.'product_attribute WHERE product_id ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_config_options WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_discount WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_filter WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_image WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_option WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_option_value WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_profile WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_recurring WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_related WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_reward WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_special WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_to_category WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_to_download WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_to_layout WHERE product_id  ="' . $product_id . '";
    DELETE FROM '.$db_prefix.'product_to_store WHERE product_id  ="' . $product_id . '";';
    mysqli_query($conexao, $sql);    
}

function str_replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

$testk = '(01010034) CZR DENTINA A4B (10G)';

include_once('chaveiro.php');

$reg300 = array();
$reg308cod = array();
$reg308sal = array();
$reg310cod = array();
$reg310psd = array();
$reg310pcd = array();

$quebralinha = "\r\n";

if (!isset($_GET["filename"])) {
    $_GET["filename"] = "";
};

$filename = $_GET["filename"];
$sidicom_file = $filename;

if ($filename == "") {
    /* Busca pelo arquivo mais recente sem LOG */
    $pasta = './ecommerce/';

    if (is_dir($pasta)) {
        $diretorio = dir($pasta);

        while ($arquivo = $diretorio->read()) {
            if ($arquivo != '..' && $arquivo != '.') {
                #Cria um Arrquivo com todos os Arquivos encontrados
                $arrayArquivos[date("Y/m/d H:i:s", filemtime($pasta . $arquivo))] = $pasta . $arquivo;
            }
        }
        $diretorio->close();
    }

    #Classificar os arquivos para a Ordem Decrescente
    krsort($arrayArquivos, SORT_STRING);

    #Checa qual mais recente não tem LOG
    foreach ($arrayArquivos as $valorArquivos) {
        //echo '<a href='.$pasta.$valorArquivos.'>'.$valorArquivos.'</a><br />';
        /* procura arquivo de log */
        $logfilename = basename($valorArquivos, ".txt");
        $logfilename = "ecommerce/log/" . $logfilename . ".log";

        if (Is_Dir($valorArquivos) == FALSE) {
            if (file_exists($logfilename) == FALSE) {
                $filename = $valorArquivos;
                break;
            }
        }
    }
} else {
    $filename = 'ecommerce/' . $filename;
}

/* ABRE LOG  Com data de Início */
if (!isset($_GET["showlog"])) {
    $_GET["showlog"] = "";
}

$showlog = $_GET["showlog"];

$logfilename = basename($filename, ".txt");
$logfilename = "ecommerce/log/" . $logfilename . ".log";

$logfile = fopen($logfilename, 'a');

$linha = "0000;" . date('Y-m-d H:i:s') . ";" . basename($filename) . ";" . $quebralinha;
fwrite($logfile, $linha);





if (file_exists($filename)) {
    $lines = file($filename);
    foreach ($lines as $line_num => $line) {

        $pos = strpos($line, ';');
        $sub = substr($line, 0, $pos);

        if ($sub == '300') {
            $reg300[] = $line;
        }

        if ($sub == '308') {
            $campos = explode(";", $line);
            $reg308cod[] = $campos[3];
            $reg308sal[] = $campos[4];
        }

        if ($sub == '310') {
            $campos = explode(";", $line);
            $reg310cod[] = $campos[2];
            $reg310psd[] = $campos[4];
            $reg310pcd[] = $campos[6];
        }
    }
} else { /* Nenhum Arquivo encontrado - Escreve no Log */
    $linha = "000E;" . "Nenhum Arquivo Encontrado;" . $quebralinha;
    fwrite($logfile, $linha);
}


/* ATUALIZAR DADOS DOS PRODUTOS, PREÇOS E QUANTIDADES */
$count = count($reg300);
/* Escreve Log */
$linha = "300T;" . $count . ";" . $quebralinha;
fwrite($logfile, $linha);
$linha = "308T;" . count($reg308cod) . ";" . $quebralinha;
fwrite($logfile, $linha);
$linha = "310T;" . count($reg310cod) . ";" . $quebralinha;
fwrite($logfile, $linha);

$atualizados = 0;
$inseridos = 0;

$test = array();
$product_count = 0;
for ($i = 0; $i < $count; $i++) {
    $linha = "";
    $campos = explode(";", $reg300[$i]);

    $prodcod = $campos[2];

    if ($campos[8] = 'A') {
        $prodsit = '1';
    }
    if ($campos[8] = 'I') {
        $prodsit = '0';
    }
    //$prodsit = $campos[8];
    $proddes = mysql_escape_string(utf8_encode($campos[9]));  /* ida_product_description */
    $unique_name = $proddes;

    $sql = 'Select p.product_id,p.unique_name,p.group_name,pd.name FROM ' . $db_prefix . 'product p';
    $sql.= ' INNER JOIN ' . $db_prefix . 'product_description pd on pd.product_id = p.product_id';
    $sql.= " WHERE p.unique_name = '$unique_name'";
    $sql_res = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($sql_res);

//    echo $unique_name;
//    echo '<br/>---------</br/>';
//    echo '<pre>';
//    print_r($row);
//    echo '</pre>';
    if (!empty($row)) {
        $test[] = $row['product_id'];
        $product_count++;
    }
}
//echo '<pre>';
//print_r($test);
//echo '</pre>';
$sql = 'Select p.product_id,p.unique_name,p.group_name,pd.name FROM ' . $db_prefix . 'product p';
$sql.= ' INNER JOIN ' . $db_prefix . 'product_description pd on pd.product_id = p.product_id';
$sql .= " LEFT JOIN " . $db_prefix . "product_to_category p2c ON (p.product_id = p2c.product_id)";
$sql .= " WHERE pd.language_id = '" . (int) 2 . "'";

$sql_res = mysqli_query($conexao, $sql);
$i = 0;
$unique_product = array();
$count = 0;
while ($row = mysqli_fetch_assoc($sql_res)) {
    if (!in_array($row['product_id'], $test)) {
        echo $row['product_id'];
        delete_related_products_tables($conexao, $row['product_id'],$db_prefix);
        
        $sql_del1 = "DELETE FROM " . $db_prefix . "product WHERE product_id = " . (int) $row['product_id'];

        echo '<br/>';
        $sql_del2 = "DELETE FROM " . $db_prefix . "product_description WHERE product_id = " . (int) $row['product_id'];
        echo $sql_del1;
        echo '<br/>';
        echo $sql_del2;
        echo "<br/>";
        mysqli_query($conexao, $sql_del1);
        mysqli_query($conexao, $sql_del2);

        echo "..........<br/>............";
        $count++;
    }
}
echo "..........<br/>. Product count for delete...........";
echo $count;
echo "..........<br/>. Available...........";
echo $product_count;
?>