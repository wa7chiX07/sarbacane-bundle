<?php


namespace Acme\SarbacaneBundle\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ListManager extends BaseManager
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function getList($limit= null,$offset=null)
    {
        $curl = parent::getCurl(self::$baseUrl.'lists?limit='.$limit.'&offset='.$offset);
        return json_decode(curl_exec($curl));
        curl_close($curl);

    }
    public static function createList($name)
    {
        $curl = parent::postCurl(self::$baseUrl.'lists',
            json_encode($name)
        );
        $result = curl_exec($curl);
        return $result;
        curl_close($curl);

    }
    public static function addContacts($contacts,$listId)
    {
        $curl = parent::postCurl(self::$baseUrl.'lists/'.$listId.'/contacts/import',
                json_encode($contacts)
            );
        return curl_exec($curl);
        curl_close($curl);

    }

}