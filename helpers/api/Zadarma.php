<?php

namespace app\helpers\api;

use Curl\Curl;
use yii\helpers\Json;

class Zadarma
{
    const BASE_URL_PART = 'https://api.zadarma.com';
    const KEY = 'e5a43a341c0d0f824fb9';
    const SECRET = '80bce2fc67b3bda76eab';
    const AVAILABLE_METHODS_URL = ['getStat' => '/v1/statistics/'];

    public static function getStatistic()
    {
        $curl = new Curl();
        $curl->setHeader('Authorization', self::KEY . ':' . self::getSign());
        $curl->get(self::BASE_URL_PART . self::AVAILABLE_METHODS_URL['getStat']);

        if ($curl->error) {
            return false;
        }

        $arrResult = Json::decode($curl->rawResponse, true);

        return $arrResult['stats'];
    }

    private static function getSign(array $data = [])
    {
        $params = http_build_query($data);
        return base64_encode(hash_hmac('sha1', self::AVAILABLE_METHODS_URL['getStat'] . $params . md5($params), self::SECRET));
    }

}