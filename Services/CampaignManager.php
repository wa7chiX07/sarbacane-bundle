<?php


namespace DotIt\SarbacaneBundle\Services;


use DotIt\SarbacaneBundle\Entity\CampaignEmail;
use DotIt\SarbacaneBundle\Entity\CampaignRecipient;
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
        return json_decode(curl_exec($curl));
        curl_close($curl);

    }
    public static function createCampaign(Campaign $campaign)
    {
        $curl = parent::postCurl(self::$baseUrl.'campaigns/email',
            json_encode($campaign)
        );
        return curl_exec($curl);
        curl_close($curl);

    }
    public static function sendCampaign($campaignId,$date = null,$time=null)
    {
        if(!$date)
            $date= date('Y-d-m');
        if(!$time)
            $time = date("H:i:s",strtotime(date("H:i:s")." +3 minutes"));
        $date = array('requestedSendDate' => $date .'T'.$time.'z');

        $campaign = self::getCampaignInfo($campaignId)->campaign;
        $curl = parent::postCurl(self::$baseUrl.'campaigns/'.$campaignId.'/send',json_encode($date));
        $result = curl_exec($curl);
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
        self::$container->get('doctrine')->getManager()->persist($campaignEmail);
        self::$container->get('doctrine')->getManager()->flush();
     //   return $result;
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
            json_encode(array('templateId'=>$templateId)));
        return curl_exec($curl);
        curl_close($curl);

    }
    public static function campaignGetRecipients($campaignId,$limit= null,$offset=null)
    {
        $curl = parent::getCurl(self::$baseUrl.'campaigns/'.$campaignId.'/recipients?limit='.$limit.'&offset='.$offset);
        return json_decode( curl_exec($curl));
        curl_close($curl);

    }



}