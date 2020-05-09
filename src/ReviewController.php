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


        if (!empty($review)) {
            //insert review by shops id
            $this->dB->insertReview($id, $review, $userName);
            $this->mainController->review();
        } else {

            $error = ['field must by set'];
            $this->mainController->review($error);
        }
    }

    //will delete review
    public function deleteReview()
    {
        $id = filter_input(INPUT_GET, 'id');

        if (!empty($id))
        {
            $this->dB->deteleShopContent('review', $id);
        }
        $this->mainController->review();
    }
}