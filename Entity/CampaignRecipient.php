<?php


namespace DotIt\SarbacaneBundle\Entity;


class CampaignRecipient
{
    protected $id;

    protected $email;

    protected $phone;

    protected $campaign;

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return CampaignEmail
     */
    public function getCampaign()
    {
        return $this->campaign;
    }


    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
        return $this;
    }



}