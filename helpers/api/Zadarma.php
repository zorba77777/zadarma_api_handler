<?php

namespace app\helpers\api;

use Curl\Curl;

class Zadarma
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

        $curl = new Curl();
        $curl->setHeader('Authorization', self::KEY . ':' . $sign);
        $curl->get(self::BASE_URL_PART . self::AVAILABLE_METHODS_URL['getStat']);

        if ($curl->error) {
            return false;
        }

        $jsonResult = $curl->rawResponse;

        $arrResult = json_decode($jsonResult, true);

        return $arrResult['stats'];
    }

}