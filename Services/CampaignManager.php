<?php


namespace DotIt\SarbacaneBundle\Services;


use DotIt\SarbacaneBundle\Entity\CampaignEmail;
use DotIt\SarbacaneBundle\Entity\CampaignRecipient;
use DotIt\SarbacaneBundle\Entity\Log;
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
        return json_decode(curl_exec($curl));
        curl_close($curl);
    }
    public static function getCampaignInfo($campaignId)
    {
        $curl = parent::getCurl(self::$baseUrl.'campaigns/'.$campaignId);
        $result = json_decode(curl_exec($curl));
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpCode>=400)
        {
            if($httpCode ==500)
            {
                $result->message = self::getErrorMessage($result->message);
            }
            throw new \Exception($result->message);
        }

        return $result;
        curl_close($curl);

    }
    public static function createCampaign(Campaign $campaign)
    {
        $curl = parent::postCurl(self::$baseUrl.'campaigns/email',
            json_encode($campaign)
        );

        $result = json_decode(curl_exec($curl));
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        $log = new Log();
        $log->setStatusCode($httpCode);
        $log->setObject('Campaign: create new campaign ');
        if($httpCode>=400)
        {
            if($httpCode==500)
                $result->message= self::getErrorMessage($result->message);
            $log->setMessage($result->message);
            self::$container->get('doctrine')->getManager()->persist($log);
            self::$container->get('doctrine')->getManager()->flush();
            throw new \Exception($result->message);
        }
        $log->setMessage('success');
        self::$container->get('doctrine')->getManager()->persist($log);
        self::$container->get('doctrine')->getManager()->flush();

        return $result;
        curl_close($curl);

    }
    public static function sendCampaign($campaignId,$date = null,$time=null)
    {

        /*if(!$date)
            $date= date('Y-d-m');
        if(!$time)
            $time = date("H:i:s",strtotime(date("H:i:s")." +3 minutes"));
        $date = array('requestedSendDate' => $date .'T'.$time.'Z');*/

        $campaign = self::getCampaignInfo($campaignId)->campaign;
        if($date && $time)
        {
            $date = array('requestedSendDate' => $date .'T'.$time.'Z');
            $curl = parent::postCurl(self::$baseUrl.'campaigns/'.$campaignId.'/send',json_encode($date));

        }
        else
        {
            $curl = parent::postCurl(self::$baseUrl.'campaigns/'.$campaignId.'/send');

        }

        $result = json_decode(curl_exec($curl));
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $log = new Log();
        $log->setObject('Campaign Send');
        $log->setStatusCode($httpcode);
        if($httpcode>=400)
        {
            if($httpcode ==500) {
                $result->message = parent::getErrorMessage($result->message);
            }
            $log->setMessage($result->message);
            self::$container->get('doctrine')->getManager()->persist($log);
            self::$container->get('doctrine')->getManager()->flush();
            throw new \Exception($result->message);


        }
        $log->setMessage('success');
        $campaignEmail = new CampaignEmail();
        $campaignEmail->setCampaignId($campaignId);;
        $campaignEmail->setKind($campaign->kind);
        $campaignEmail->setName($campaign->name);
        $campaignEmail->setStatus($result);
        self::$container->get('doctrine')->getManager()->persist($campaignEmail);
        $recipients = self::campaignGetRecipients($campaignId);
        foreach ($recipients as $recipient)
        {
            $campaignRecipient = new CampaignRecipient();
            $campaignRecipient->setPhone($recipient->phone);
            $campaignRecipient->setEmail($recipient->email);
            self::$container->get('doctrine')->getManager()->persist($campaignRecipient);
            $campaignEmail->addRecipient($campaignRecipient);
        }
        self::$container->get('doctrine')->getManager()->persist($log);
        self::$container->get('doctrine')->getManager()->persist($campaignEmail);
        self::$container->get('doctrine')->getManager()->flush();
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
        $result = json_encode( curl_exec($curl));
        $http_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        $log = new Log();
        $log->setIdObject($campaignId);
        $log->setObject('set recupients to campaign');
        $log->setStatusCode($http_code);
        if($http_code>=400)
        {
            if($http_code==500)
                $result->message = self::getErrorMessage($result->message);
            $log->setMessage($result->message);
            self::$container->get('doctrine')->getManager()->persist($log);
            self::$container->get('doctrine')->getManager()->flush();
        }
        $log->setMessage('success');
        self::$container->get('doctrine')->getManager()->persist($log);
        self::$container->get('doctrine')->getManager()->flush();
        return $result;

        curl_close($curl);
    }
    public static function campaignSetModel($campaignId,$templateId)
    {

        $curl = parent::postCurl(self::$baseUrl.'campaigns/'.$campaignId.'/content',
            json_encode(array('templateId'=>$templateId)));
        $result = json_decode( curl_exec($curl));
        $http = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        $log = new Log();
        $log->setStatusCode($http);
        $log->setIdObject($campaignId);
        $log->setObject('Set Model to campaign Model id: '.$templateId);
        if ($http>=400)
        {
            if($http == 500)
                $result->message = parent::getErrorMessage($result->message);
            $log->setMessage($result->message);
            self::$container->get('doctrine')->getManager()->persist($log);
            self::$container->get('doctrine')->getManager()->flush();
            throw new \Exception($result->message);


        }
        $log->setMessage('success');
        self::$container->get('doctrine')->getManager()->persist($log);
        self::$container->get('doctrine')->getManager()->flush();

        return $result;
        curl_close($curl);

    }
    public static function campaignGetRecipients($campaignId,$limit= null,$offset=null)
    {
        $curl = parent::getCurl(self::$baseUrl.'campaigns/'.$campaignId.'/recipients?limit='.$limit.'&offset='.$offset);
        return json_decode( curl_exec($curl));
        curl_close($curl);

    }



}
