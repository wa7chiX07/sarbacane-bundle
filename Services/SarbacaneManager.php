<?php


namespace Acme\SarbacaneBundle\Services;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class SarbacaneManager extends BaseManager
{
    public function __construct(ParameterBagInterface $parameterBag)
    {
        parent::__construct($parameterBag);
    }

    public static function getCampaigns($limit= null,$offset=null)
    {
        $curl = parent::getCurl(self::$baseUrl.'campaigns');
        //$curl = curl_setopt($curl,CURLOPT_POSTFIELDS,'limit='.$limit.'&offset='.$offset);
        return curl_exec($curl);
        curl_close($curl);
    }
    public static function createCampaign($campaign)
    {
        $curl = parent::postCurl(self::$baseUrl.'campaigns/email',
            json_encode($campaign)
        );
        $result = curl_exec($curl);
        var_dump($result);die();
        return $result;
        curl_close($curl);

    }
    public static function sendCampaign($reference)
    {
        $curl = parent::postCurl(self::$baseUrl.'campaigns/'.$reference.'/send',null);
        $result = curl_exec($curl);
        var_dump($result);die();
        return $result;
        curl_close($curl);

    }



}