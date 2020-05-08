<?php


namespace Tudublin;


class CommentController
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
    //will delete comment
    public function deleteComment()
    {
        $id = filter_input(INPUT_GET, 'id');

        $this->dB->deteleShopContent('comment', $id);

        $this->mainController->review();
    }

    //on click 'permit' will send comment online and unregister user will by able to see
    public function permitComment()
    {
        $id = filter_input(INPUT_GET, 'id');

        $this->dB->allowComment($id, $permit=1);

        $this->mainController->review();
    }
    //process comment into table with user who posted details
    public function processComment()
    {
        $comment = filter_input(INPUT_POST, 'comment');
        $comentId = filter_input(INPUT_POST, 'id');
        $userComanted = filter_input(INPUT_POST, 'userName');
        $ifPayed = filter_input(INPUT_POST, 'ifPayed');

        $permit = 1;

        if(!empty($comment))
        {
            if(null == $userComanted)
            {
                $userComanted = 'anonymous';
                $ifPayed = 0;
                $permit =0;
             }

            $this->dB->insertComment($comentId, $comment, $userComanted, $permit, $ifPayed );

            $this->mainController->review();
        }else{
            $this->mainController->review('field is empty');
        }
    }



}