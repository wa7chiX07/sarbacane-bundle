<?php


namespace DotIt\SarbacaneBundle\Services;


use DotIt\SarbacaneBundle\Entity\Log;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ListManager extends BaseManager
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public static function getList($limit= null,$offset=null)
    {
        $curl = parent::getCurl(self::$baseUrl.'lists?limit='.$limit.'&offset='.$offset);
        $result = json_decode(curl_exec($curl));
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($httpCode>=400)
        {
            if($httpCode ==500)
                $result->message = self::getErrorMessage($result->message);
            throw new \Exception($result->message);
        }
        return $result;
        curl_close($curl);

    }
    public static function createList($name)
    {
        $curl = parent::postCurl(self::$baseUrl.'lists',
            json_encode(array('name' => $name))
        );
        $result =  json_decode( curl_exec($curl));
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        $log = new Log();
        $log->setObject('List: creat new list');
        $log->setStatusCode($httpCode);
        if($httpCode>=400)
        {
            if($httpCode == 500)
                $result->message = self::getErrorMessage($result->message);
            $log->setMessage($result->message);
            self::$container->get('doctrine')->getManager()->persist($log);
            self::$container->get('doctrine')->getManager()->flush($log);
            throw new \Exception($result->message);
        }
        $log->setIdObject($result->id);
        $log->setMessage('success');
        self::$container->get('doctrine')->getManager()->persist($log);
        self::$container->get('doctrine')->getManager()->flush($log);
        return $result;
        curl_close($curl);

    }
    public static function addContacts($listId,$contacts)
    {
        $curl = parent::postCurl(self::$baseUrl.'lists/'.$listId.'/contacts/import',
                json_encode($contacts)
            );
        $result = json_decode(curl_exec($curl));
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        $log = new Log();
        $log->setIdObject($listId);
        $log->setStatusCode($httpCode);
        $log->setObject('List: Add contacts to list');
        if($httpCode>=400)
        {
            if($httpCode==500)
                $result->message = self::getErrorMessage($result->message);
            $log->setMessage($result->message);
            self::$container->get('doctrine')->getManager()->persist($log);
            self::$container->get('doctrine')->getManager()->flush($log);
            throw new \Exception($result->message);
        }
        $log->setMessage('success');
        self::$container->get('doctrine')->getManager()->persist($log);
        self::$container->get('doctrine')->getManager()->flush($log);
        return $result;
        curl_close($curl);

    }

}
