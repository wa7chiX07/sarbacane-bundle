<?php


namespace DotIt\SarbacaneBundle\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;

class ModelManager extends BaseManager
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }
    public static function getModels($limit= null,$offset= null)
    {
        $curl = parent::getCurl(self::$baseUrl.'templates?limit='.$limit.'&offset='.$offset);
        $result = json_decode(curl_exec($curl));
        return $result->templates;
        curl_close($curl);
    }

}