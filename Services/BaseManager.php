<?php


namespace Acme\SarbacaneBundle\Services;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BaseManager
{
    protected static $baseUrl = 'https://sarbacaneapis.com/v1/';
    protected static $apiKey;
    protected static $accountId;
    public function __construct(ParameterBagInterface $parameterBag)
    {
        self::$apiKey= $parameterBag->get('apiKey');
        self::$accountId = $parameterBag->get('accountId');
    }

    private static function getCurlWithAuth($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_HTTPHEADER,[
            'Content-Type: application/json',
            'apiKey: '. self::$apiKey,
            'accountId: '. self::$accountId
        ]);
        return $curl;
    }
    protected static function getCurl($url)
    {
        $curl = self::getCurlWithAuth($url);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        return $curl;
    }
    protected static function postCurl($url,$fields)
    {
        $curl = self::getCurlWithAuth($url);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        return $curl;

    }
    protected static function putCurl($url,$fields)
    {
        $curl = self::getCurlWithAuth($url);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'PUT');
        curl_setopt($curl,CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        return $curl;
    }

}