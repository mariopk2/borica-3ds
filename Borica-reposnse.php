<?php
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";
    $responseAnswer = $_POST['RC'];//00-ok,
    $responseMessage = $_POST['STATUSMSG'];
    $responseOrder = $_POST['ORDER'];
    $responseRef = $_POST['INT_REF'];
    $reposnseCard = $_POST['CARD'];
    $responseAmount = $_POST['AMOUNT'];
    $dateResponse = date('Y-m-d H:i:s');
    $nonce = $_POST['NONCE'];
    $p_sign = $_POST['P_SIGN'];

    if($responseAnswer == '00'){
        echo "OK"
    }else{
        echo "Fatal error!";
    }
?>