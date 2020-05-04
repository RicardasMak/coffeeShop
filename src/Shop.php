<?php
namespace Tudublin;


class Shop
{
    private $id;
    private $date;
    private $shopName;
    private $userName;
    private $profilePayed;
    private $shopOwner;

    public function getShopOwner()
    {
        return $this->shopOwner;
    }

    public function setShopOwner($shopOwner)
    {
        $this->shopOwner = $shopOwner;
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

    public function getShopName()
    {
        return $this->shopName;
    }

    public function setShopName($shopName)
    {
        $this->shopName = $shopName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
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