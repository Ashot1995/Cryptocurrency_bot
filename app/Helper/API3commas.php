<?php


namespace App\Helper;


class API3commas
{
    public static function callAPI($method, $url1, $data) {
        $url = 'https://api.3commas.io'.$url1;
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PATCH":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        $signature = hash_hmac('sha256', $url1, '8495c1825f16b0473b3b7a1dd712a889e0cb6b9e53001eda9e59d39808b65151b43f317f0ea6b5a57f54d01e19419678d7856a0260e168894579692ddc3c1ca8aa79167b9f46149c48acc52eb3ef08fff0115f716cf6ae24ab1b7a071fd19c23b006d0d7');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: 1523c6d6933641e38da8c09bef44ce34c219da76781447c8a6f393bb632fceab',
            'SIGNATURE: '.$signature,
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        dd($result);
        return $result;
    }
}
