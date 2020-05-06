<?php
namespace Tudublin;


class ShopController
{
    private $dB;
    private $mainController;
    private $permit;

    public function __construct($twig)
    {
        $this->dB = new Db();

        $this->mainController = new MainController($twig);
        $this->permit = 0;
    }
    //create shop
    public function processShop()
    {
        $shopName = filter_input(INPUT_POST, 'shop');
        $shopOwner = filter_input(INPUT_POST, 'shopOwner');

        $userName = $_SESSION['userName'];
        $role = $_SESSION['role'];
        $ifPayed = $_SESSION['ifPayed'];

        $checkRole = $this->checkRole($shopOwner);

        if($checkRole == 1)
        {
            $checkShopName = $this->checkShopName($shopName);

            if($checkShopName == 1) {

                if($role == 'staff')
                {
                    $this->dB->insertShop($shopName, $userName, $ifPayed, $shopOwner);
                    $this->mainController->review('created shop');
                }

            }else{
                $error = $checkShopName;
                $this->mainController->review($error);
            }

        }else{

            $error = $checkRole;
            $this->mainController->review($error);
        }

    }
    //will check if shop owners name matches role
    private function checkRole($shopOwner)
    {
        if (!empty($shopOwner)) {
            $acc = $this->dB->findUser($shopOwner);

            if (false == $acc) {
                return 'user doesnt exist';
            } elseif ($acc->getRole() != "shop") {
                return 'is not shop owner';

            } else {
                return 1;
            }
        } else {
            return 'empty user field';
        }
    }
    //will check shop name so it would not duplicate
    private function checkShopName($shopName)
    {
        if(!empty($shopName))
        {
            $shopNameDb = $this->dB->findShop($shopName);

            if($shopNameDb == false)
            {
                return 1;
            }
            if ($shopNameDb->getShopName() == $shopName)
            {
                return 'shop already exist';
            }
        }
        else{
            return 'shop name field is empty';
        }
    }
    //delete shop with comments and reviews
    public function deleteShop()
    {
        $id = filter_input(INPUT_GET, 'id');

        $this->dB->detele('shop', $id);
        $this->dB->detele('comment', $id);
        $this->dB->detele('review', $id);

        $this->mainController->review('shop deleted');
    }

}