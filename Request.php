<?php

require 'AES.php';

class Request {
    public $mKey = "05a671c66aefea124cc08b76ea6d30bb";
    public $mMerchantCode = "87557050";
    public $mCharacter = "UTF-8";

    public function url() {
        return "";
    }

    public function requestParams() {
        $params = $this->makeRequestParams();
        $sign = $this->generateSign($params);
        $params['sign'] = $sign;
        return $params;
    }

    protected function makeRequestParams() {
        return array();
    }

    private function generateSign($params) {
        $str = "";
        ksort($params);
        foreach($params as $key => $value) {
            $str = $str."&".$key."=".$value;
        }
        $str = substr($str, 1);
        $str = $str."&key=".$mKey;
        return md5($str);
    }
}

class PayRequest extends Request {

    public function url() {
        return "http://47.244.41.184/gateway/create.html";
    }

    protected function makeRequestParams() {
        $milliseconds = round(microtime(true) * 1000);
        return array(
            'inform_url' => 'http://www.abc.com',
            'input_charset' => $mCharacter,
            'merchant_code' => $mMerchantCode,
            'order_amount' => AES::encrypt("90.00", $mKey),
            'order_no' => $milliseconds,
            'order_time' => '2019-12-20 18:38:11',
            'pay_type' => '1'
        );
    }
}