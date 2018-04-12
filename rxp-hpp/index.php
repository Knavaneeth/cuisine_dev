<?php 

/* print_r($_POST);
exit; */

require_once ('vendor/autoload.php');



use com\realexpayments\hpp\sdk\domain\HppRequest;

use com\realexpayments\hpp\sdk\RealexHpp;

use com\realexpayments\hpp\sdk\RealexValidationException;

use com\realexpayments\hpp\sdk\RealexException;



$hppRequest = (new HppRequest())

    ->addMerchantId($_POST['chip_pin_client_id'])

    ->addAccount("internet")

    ->addAmount($_POST['total_amount'])

    ->addCurrency("EUR")

    ->addAutoSettleFlag(TRUE);



$realexHpp = new RealexHpp($_POST['chip_pin_SharedSecret']);



try {

    $requestJson = $realexHpp->requestToJson($hppRequest);

    echo $requestJson;

    // code here for your application to pass the JSON string to the client-side library

    return $requestJson;

}

catch (RealexValidationException $e) {

    echo $e->getMessage();
    return $e->getMessage();

}

catch (RealexException $e) {

    echo $e->getMessage();
    return $e->getMessage();

}

?>