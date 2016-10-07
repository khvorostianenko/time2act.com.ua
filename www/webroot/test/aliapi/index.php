<?php

function show_out($out){
    $Fl = 0;
    $str = '<table style="border: 1px solid black">';
    foreach($out as $product_data){
        $str.= '<tr style="border: 1px solid black">';
        $header = '';
        $row = '';
        foreach ($product_data as $key=>$value){
            if($Fl == 0){
                $header.= '<td style="border: 1px solid black">'.$key.'</td>';
            }
            $row.= '<td style="border: 1px solid black">'.$value.'</td>';
        }
        if($header){
            $header = '</tr>'.$header.'<tr style="border: 1px solid black">';
            $Fl = 1;
        }
        $str.=$header.$row.'</tr>';
    }
    $str.='</table>';
    return $str;
}


if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'http://gw.api.alibaba.com/openapi/param2/2/portals.open/api.listPromotionProduct/11315');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "fields=productId,productTitle,productUrl,imageUrl,originalPrice,salePrice,discount,evaluateScore,commission,commissionRate,30daysCommission,volume,packageType,lotNum,validTime,storeName,storeUrl&keywords=xiaomi");
    $out = curl_exec($curl);
    $out = json_decode($out, true);
    curl_close($curl);
}
echo show_out($out['result']['products']);

if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'http://gw.api.alibaba.com/openapi/param2/2/portals.open/api.getPromotionProductDetail/11315');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "fields=productId,productTitle,productUrl,imageUrl,originalPrice,salePrice,discount,evaluateScore,commission,commissionRate,30daysCommission,volume,packageType,lotNum,validTime,storeName,storeUrl&productId=32622055309");
    $out = curl_exec($curl);
    $out = json_decode($out, true);
    curl_close($curl);
}
echo show_out($out);


