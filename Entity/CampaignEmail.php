<?php


namespace DotIt\SarbacaneBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CampaignEmail
{
    protected $id;

    protected $name;

    protected $kind;

    protected $campaignId;

    protected $recipients;

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @param mixed $kind
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    /**
     * @return mixed
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

    /**
     * @param mixed $campaignId
     */
    public function setCampaignId($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    /**
     * @return Collection | CampaignRecipient
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    public function addRecipient(CampaignRecipient $recipient)
    {
        if(!$this->recipients->contains($recipient))
        {
            $this->recipients[] = $recipient;
            $recipient->setCampaign($this);
        }
        return $this;
    }




}