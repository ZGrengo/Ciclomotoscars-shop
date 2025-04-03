<?php
    print_r($_GET);
?>

$ClientID="Ac3yarg5W_DyUtvDzUVHVDoD8TpeAB_f3TOGU3JgyZsZTdYXYxEPOQgJx3X3hcYo_VYRo-esB0s2b22l";
$Secret="ECrokV8-DSkjFEPD-nBnNx36yyGVr61xV-N0P0o1ROj5-FH2pblTbRe3iEnRNmeHLM9FWXqarh9jB_YL";

        $Login=curl_init("https://api-m.sandbox.paypal.com/v1/oauth2/token");

        curl_setopt($Login,CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($Login,CURLOPT_USERPWD,$ClientID.":".$Secret);
        
        curl_setopt($Login,CURLOPT_POSTFIELDS,"grant_type=client_credentials");

        $Respuesta=curl_exec($Login);

        print_r($Respuesta);