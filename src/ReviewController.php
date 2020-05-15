<?php
namespace Tudublin;


class ReviewController
{
    private $dB;
    private $mainController;

    public function __construct($twig)
    {
        $this->dB = new Db();

        $this->mainController = new MainController($twig);
    }

    //insert review after checks have done
    public function processReview()
    {
        $id = filter_input(INPUT_POST, 'id');
        $review = filter_input(INPUT_POST, 'review');
        $userName = filter_input(INPUT_POST, 'userName');

        //checks if shop owner matches log in user, return boolean
        $shopOwnerCheck = $this->getShopOwner($id);

        if($shopOwnerCheck or 'staff' == $_SESSION['role']) {

            if (!empty($review)) {
                //insert review by shops id
                $this->dB->insertReview($id, $review, $userName);
                $this->mainController->review();
            } else {

                $error = ['field must by set'];
                $this->mainController->review($error);
            }
        }else{

            //sends to error page
            $this->mainController->error();
        }
    }

    //will delete review
    public function deleteReview()
    {
        $id = filter_input(INPUT_GET, 'id');

        //checks if shop owner matches log in user, return boolean
        $shopOwnerCheck = $this->getShopOwner($id);

        if($shopOwnerCheck or 'staff' == $_SESSION['role'])
        {
            //deletes review from db
            $this->dB->deteleShopContent('review', $id);

            $this->mainController->review();
        }else{

            //sends to error page
            $this->mainController->error();
        }
    }

    //get shops name
    private function getShopOwner($id)
    {
        //check if reviews id is not empty
        if (!empty($id)) {

            $reviews = $this->dB->getAllReview();

            //loop all reviews
            foreach ($reviews as $review)
            {
                //finds review by id (idUnque)
                if($review->getIdUnque() == $id)
                {
                   $shops = $this->dB->getAllShops();

                   foreach ($shops as $shop)
                   {
                       //compare shops id with reviews id
                       if ($shop->getId() == $review->getId())
                       {
                           //compares shops owner with user who is loged in
                           if ($shop->getShopOwner() == $_SESSION['userName'])
                           {
                               return true;
                           }
                       }
                   }
                }
            }
        }
        return false;
    }
}