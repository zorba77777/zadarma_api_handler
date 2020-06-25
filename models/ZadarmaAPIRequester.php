<?php

namespace app\models;

class ZadarmaAPIRequester
{
    const BASE_URL_PART = 'https://api.zadarma.com';
    const KEY = 'e5a43a341c0d0f824fb9';
    const SECRET = '80bce2fc67b3bda76eab';
    const AVAILABLE_METHODS_URL = ['getStat' => '/v1/statistics/'];

    public static function getStatistic()
    {
        $data = [];

        $params = http_build_query($data);

        $sign = base64_encode(hash_hmac('sha1', self::AVAILABLE_METHODS_URL['getStat'] . $params . md5($params), self::SECRET));
        $headers = array('Authorization: ' . self::KEY . ':' . $sign);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::BASE_URL_PART . self::AVAILABLE_METHODS_URL['getStat']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $jsonResult = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            return false;
        }

        $arrResult = json_decode($jsonResult, true);

        return $arrResult['stats'];
    }

}