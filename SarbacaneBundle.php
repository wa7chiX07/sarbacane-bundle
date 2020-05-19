<?php

namespace Acme\SarbacaneBundle;

use Acme\SarbacaneBundle\Services\SarbacaneManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SarbacaneBundle extends Bundle
{
//    static $manager;
//    public function __construct(SarbacaneManager $manager)
//    {
//        self::$manager = $manager;
//    }
    public static function sarbacanTest()
    {
        return SarbacaneManager::getCampaigns();
    }

}
