<?php


namespace DotIt\SarbacaneBundle\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class CampaignManager extends BaseManager
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public static function getCampaigns($limit= null,$offset=null)
    {
        $curl = parent::getCurl(self::$baseUrl.'campaigns?limit='.$limit.'&offset='.$offset);
        //$curl = curl_setopt($curl,CURLOPT_POSTFIELDS,'limit='.$limit.'&offset='.$offset);
        return json_decode(curl_exec($curl));
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
    public static function sendCampaign($campaignId)
    {
        $curl = parent::postCurl(self::$baseUrl.'campaigns/'.$campaignId.'/send',null);
        $result = curl_exec($curl);
        var_dump($result);die();
        return $result;
        curl_close($curl);

    }
    public static function campaignSetList($campaignId, $listId)
    {
        $curl = parent::postCurl(self::$baseUrl.'campaigns/'.$campaignId.'/list',
            json_encode($listId));
        return curl_exec($curl);
        curl_close($curl);
    }
    public static function campaignSetRecipients($campaignId,$recipients)
    {
        $curl = parent::postCurl(self::$baseUrl.'campaigns/'.$campaignId.'/recipients',
            json_encode($recipients));
        return curl_exec($curl);
        curl_close($curl);
    }
    public static function campaignSetModel($campaignId,$templateId)
    {
        $curl = parent::postCurl(self::$baseUrl.'campaigns/'.$campaignId.'/content',
            json_encode($templateId));
        return curl_exec($curl);
        curl_close($curl);

    }
    public static function campaignGetRecipients($campaignId,$limit= null,$offset=null)
    {
        $curl = parent::getCurl(self::$baseUrl.'campaigns/'.$campaignId.'/recipients');
        $curl = curl_setopt($curl,CURLOPT_POSTFIELDS,'limit='.$limit.'&offset='.$offset);
        return curl_exec($curl);
        curl_close($curl);

    }



}