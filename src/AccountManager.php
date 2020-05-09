<?php

namespace Tudublin;


class AccountManager
{
    private $db;
    private $mainController;

    public function __construct($twig)
    {
        $this->db = new Db();
        $this->mainController = new MainController($twig);
    }

    //delete account
    public function deleteUser()
    {
        $userDelete = filter_input(INPUT_POST, 'userNameDelete');

        if (!empty($userDelete)) {
            $acc = $this->db->findUser($userDelete);

            if ($acc != null) {
                $this->db->deleteUser($userDelete);

                $message = ['account deleted successfully'];
                $this->mainController->secret($temp = null, $message);
            } else {

                $error = ['user not found'];
                $this->mainController->secret($temp = null, $error);
            }
        } else {

            $error = ['field is empty'];
            $this->mainController->secret($temp = null, $error);
        }
    }

    //create account
    public function createACC()
    {
        $userName = filter_input(INPUT_POST, 'userNameCreate');
        $password = filter_input(INPUT_POST, 'passwordCreate');
        $passConfirm = filter_input(INPUT_POST, 'passwordConfirm');
        $payed = filter_input(INPUT_POST, 'payment');
        $role = filter_input(INPUT_POST, 'role');


        $userNameCheck = $this->checkUserName($userName);
        $passwordCheck = $this->passwordCheck($password, $passConfirm);

        if (sizeof($userNameCheck) == 0 and sizeof($passwordCheck) == 0) {
            $passwordHashed = $this->hashPassword($password);
            $this->db->createUser($userName, $passwordHashed, $role, $payed);

            $message = ['account crated'];
            $this->mainController->secret($message);
        } elseif (sizeof($userNameCheck) > 0) {

            $this->mainController->secret($userNameCheck);

        } elseif (sizeof($passwordCheck) > 0) {
            $this->mainController->secret($passwordCheck);
        } else {

            $this->mainController->secret();
        }
    }

    //check password
    private function passwordCheck($password, $passwordConfirm)
    {
        $error = [];

        if (empty($password) and empty($passwordConfirm)) {
            $error = ['password field is empty'];
        } elseif ($password != $passwordConfirm) {
            $error = ['password doesnt match'];
        }

        return $error;
    }

    //check user name
    private function checkUserName($userName)
    {
        $error = [];
        $acc = $this->db->findUser($userName);

        if (empty($userName)) {

            $error = ['missing user name'];

        } elseif ($acc != null) {

            if ($acc->getUserName() == $userName) {

                    $error = ['that user name is already in use'];
            }
        }

        return $error;
    }

    //hash password
    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
