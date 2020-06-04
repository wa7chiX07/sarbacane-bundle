<?php


namespace DotIt\SarbacaneBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DotIt\SarbacaneBundle\Entity\BaseEntity as BaseEntity;

class CampaignEmail extends BaseEntity
{
    protected $id;

    protected $name;

    protected $kind;

    protected $campaignId;

    protected $status;

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
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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