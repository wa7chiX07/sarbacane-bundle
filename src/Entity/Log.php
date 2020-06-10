<?php


namespace DotIt\SarbacaneBundle\Entity;

/**
 * Class Log
 * @package DotIt\SarbacaneBundle\Entity
 * @author Chadli Ouhichi <louhichi.chadli93@outlook.fr>
 */
class Log extends BaseEntity
{

    protected $id;

    protected $idObject;

    protected $object;

    protected $statusCode;

    protected $message;

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
    public function getIdObject()
    {
        return $this->idObject;
    }

    /**
     * @param mixed $idObject
     */
    public function setIdObject($idObject)
    {
        $this->idObject = $idObject;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }



}
