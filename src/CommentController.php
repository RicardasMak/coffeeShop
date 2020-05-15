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

        //find shop owners name by comments id return boolean
        $shopName = $this->getShopOwner($id);

        //if shop owner or role is staff will delete comment
        if($shopName or $_SESSION['role'] == 'staff')
        {
            //send to db id to delete comment
            $this->dB->deteleShopContent('comment', $id);

            //refresh page
            $this->mainController->review();
        }
        else{
            //else will send to error page
            $this->mainController->error();
        }
    }

    //on click 'permit' will send comment online and unregister user will by able to see
    public function permitComment()
    {
        $id = filter_input(INPUT_GET, 'id');

        //find shop owners name by comments id return boolean
        $shopName = $this->getShopOwner($id);

        //if shop owner or role is staff will change comment to go online
        if($shopName or $_SESSION['role'] == 'staff')
        {
            $this->dB->allowComment($id, $permit=1);

            //refresh page
            $this->mainController->review();
        }
        else{
            //else will send to error page
            $this->mainController->error();
        }

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
            $this->mainController->review();
        }
    }
    //will check if user who is connected is shop owner
    private function getShopOwner($id)
    {
        $comment = $this->dB->getAllComment();
        $shop = $this->dB->getAllShops();

        //loops comments
        foreach ($comment as $com)
        {
            //compares comment id
            if($com->getIdUnque() == $id)
            {
                //loops shop if comment find with id
                foreach ($shop as $findShop)
                {
                    //compares shop id with comments id if matches
                    if($findShop->getId() == $com->getId());
                    {
                        //compare if logged in user is shop owner
                        if($_SESSION['userName'] == $findShop->getShopOwner())
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