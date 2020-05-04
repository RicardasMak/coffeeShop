<?php
namespace Tudublin;

class Comment
{
    private $idUnque;
    private $id;
    private $date;
    private $comment;
    private $userName;
    private $permit;
    private $profilePayed;

    public function getIdUnque()
    {
        return $this->idUnque;
    }

    public function setIdUnque($idUnque)
    {
        $this->idUnque = $idUnque;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getPermit()
    {
        return $this->permit;
    }

    public function setPermit($permit)
    {
        $this->permit = $permit;
    }

    public function getProfilePayed()
    {
        return $this->profilePayed;
    }

    public function setProfilePayed($profilePayed)
    {
        $this->profilePayed = $profilePayed;
    }


}