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
        $shopOwnerCheck = $this->getReviewName($id);

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
        $shop = $this->dB->getAllShops();

        foreach ($shop as $shops)
        {
           if ($shops->getId() == $id)
           {
               if($shops->getShopOwner() == $_SESSION['userName'])
               {
                   return true;
               }
           }
        }

        return false;
    }

    //get id to delete review
    private function getReviewName($id)
    {
        $review = $this->dB->getAllReview();

        foreach ($review as $reviews)
        {
            if($reviews->getIdUnque() == $id)
            {
                $shop = $this->dB->getAllShops();

                foreach ($shop as $shops)
                {
                    if($shops->getId() == $reviews->getId())
                    {
                        if($shops->getShopOwner() == $_SESSION['userName'])
                        {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}