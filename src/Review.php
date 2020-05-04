<?php
namespace Tudublin;


class review
{
    private $idUnque;
    private $id;
    private $date;
    private $review;
    private $userName;

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

    public function getReview()
    {
        return $this->review;
    }

    public function setReview($review)
    {
        $this->review = $review;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

}