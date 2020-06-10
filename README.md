# sarbacaneBundle

sarbacaneBundle is a Symfony 3.4 bundle for sarbacane .

## config.yml

Use this line in config.yml file.

```yml
sarbacane:
    apiKey: '%apiKey%'
    accountId: '%accountId%'
```

## parameters.yml

```yml
apiKey: [YOUR_APIKEY]
accountId: [YOUR_ACCOUNTID]
```
## composer.json
```
"autoload": {
        "psr-4": {
            "DotIt\\SarbacaneBundle\\": "[bundle source]",
            ......
        },
```
## AppKernel.php
```
$bundles = [
           .. ,
           .. ,
           new DotIt\SarbacaneBundle\SarbacaneBundle(),
        ];
```
## Command
```
in terminal execute these command

$ composer dump-autoload

**** For update database table and add bundle new table *****  
$ ./bin/console doctrine:schema:update --force


``` 
## Usage
```
/**** Create email new campaign *******/


$campaign = new Campaign();
$campaign->name='New Campaign';
$campaign->aliasFrom='Sender';
$campaign->subject='Object';
$campaign->emailFrom='examole@example.com';
$campaign->aliasReplyTo='sender';
$campaign->emailReplyTo='example@example.com';
$campaignID = CampaignManager::createCampaign($campaign);

/******ADD RECIPIENTS TO A CAMPAIGN*****/
$recipients =array(
            array('email' => 'recipient1.@example.com','phone' => '216xxxxxxxx'),
            array('email' => 'recipient2@example.com','phone' => '2162xxxxxxx')
        );
CampaignManager::campaignSetRecipients($campaignID,$recipients);

/******* SEND CAMPAIGN ********************/
CampaignManager::sendCampaign($campaignID);

/***** GET CAMPAIGNS *********************/

//$ limit and offset can be null 
$campaigns = CampaignManager::getCampaigns($limit, $offset);

/********* SET A LIST TO CAMPAIGN ********/

CampaignManager::campaignSetList($campaignID,$listID);

/********* SET A MODEL TO CAMPAIGN ********/

CampaignManager::campaignSetModel($campagnID,$modelID);

/*****  CREATE NEW LIST ********/

$listID = ListManager::createList($name);

/****** ADD CONTACTS TO LIST *******/
$contacts= array(
            array('email' => 'contact1.@example.com','phone' => '216xxxxxxxx'),
            array('email' => 'contact2@example.com','phone' => '2162xxxxxxx')
        );
ListManager::addContacts($listID,$contacts);

/****** GET LIST ******************/

//$ limit and offset can be null 
$lists = ListManager::getList($limit,$offset);

 

```



## License
[DOTIT](http://www.dotit-corp.com/)
