<?php


namespace DotIt\SarbacaneBundle\Services;


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
        return json_decode( curl_exec($curl));
        curl_close($curl);

    }
    public static function addContacts($listId,$contacts)
    {
        $curl = parent::postCurl(self::$baseUrl.'lists/'.$listId.'/contacts/import',
                json_encode($contacts)
            );
        return json_decode(curl_exec($curl));
        curl_close($curl);

    }

}