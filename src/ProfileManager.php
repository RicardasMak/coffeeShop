<?php
namespace Tudublin;


class ProfileManager
{
    private $dB;
    private $mainController;

    public function __construct($twig)
    {
        $this->dB = new Db();
        $this->mainController = new MainController($twig);
    }
    //will update profile
    public function updateProfile()
    {
        $email = filter_input(INPUT_POST, 'email');
        $occupation = filter_input(INPUT_POST, 'occupation');
        $phone = filter_input(INPUT_POST, 'phone');

        $user = $_SESSION['userName'];

        //send values to db to update account
        $this->dB->updateProfile($user, $email, $occupation, $phone);

        //extracts values from db of account
        $acc = $this->getProfile($user);

        //call profile .html.twig and pass account values
        $this->mainController->profile($acc);

    }
    //extract values from db
    private function getProfile($user)
    {
        $acc = $this->dB->findUser($user);

        if(isset($acc))
        {
            return $account = ['email'=> $acc->getEmail(),
                        'occupation' => $acc->getOccupation(),
                        'phone' => $acc->getPhone()
                    ];
        }
        return null;
    }
    //pass accounts profile who put comment in to page
    public function displayProfile()
    {
        $userName = filter_input(INPUT_GET, 'name');

        $acc = $this->dB->findUser($userName);

        $this->mainController->profileDisplay($acc);
    }
}