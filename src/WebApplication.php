<?php
namespace Tudublin;

class WebApplication
{
    private $mainController;
    private $commentController;
    private $loginController;
    private $profileManager;
    private $reviewController;
    private $shopController;
    private $accountManager;
    private $db;

    private $twig;
    const PATH_TO_TEMPLATES = __DIR__. '/../templates';

    public function __construct()
    {
        $this->twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader(self::PATH_TO_TEMPLATES));

        $this->commentController = new CommentController($this->twig);
        $this->mainController = new MainController($this->twig);
        $this->loginController = new LogInController($this->twig);
        $this->profileManager = new ProfileManager($this->twig);
        $this->reviewController = new ReviewController($this->twig);
        $this->shopController = new ShopController($this->twig);
        $this->accountManager = new AccountManager($this->twig);
        $this->db = new Db();

    }

    public function run()
    {
        $temp = null;

        $action = filter_input(INPUT_GET, 'action');
        if(empty($action))
        {
            $action = filter_input(INPUT_POST, 'action');
        }

        switch ($action)
        {
            case 'about':
                $this->mainController->about();
                break;

            case 'review':
                $this->mainController->review();
                break;

            case 'login':
                $this->mainController->login($error =[]);
                break;

            case 'processLogin':
                $this->loginController->processLogin();
                break;

            case 'processShop':
                if('staff' == $_SESSION['role'])
                {
                    $this->shopController->processShop();
                }
                else{
                    $this->mainController->error();
                }
                break;

            case 'logout':
                $this->mainController->logOut();
                break;

            case 'secret':
                if('admin' == $_SESSION['role']) {
                    $this->mainController->secret();
                }
                else{
                    $this->mainController->error();
                }
                break;

            case 'craeteAccount':
                if('admin' == $_SESSION['role']) {
                    $this->accountManager->createACC();
                }
                else{
                    $this->mainController->error();
                }
                break;

            case 'deleteAccount':
                if('admin' == $_SESSION['role']) {
                    $this->accountManager->deleteUser();
                }
                else{
                    $this->mainController->error();
                }
                break;

            case 'deleteComment':
                if('staff' == $_SESSION['role'] or 'shop' == $_SESSION['role'])
                {
                    $this->commentController->deleteComment();
                }
                else{
                    $this->mainController->error();
                }
                break;

            case 'permitComment':
                if('staff' == $_SESSION['role'] or 'shop' == $_SESSION['role'])
                {
                    $this->commentController->permitComment();
                }
                else{
                    $this->mainController->error();
                }
                break;

            case 'profile':
                if(1 == $_SESSION['ifPayed'])
                {
                    $this->mainController->profile($error =[]);

                }else{
                    $this->mainController->error();
                }
                break;

            case 'profileSubmit':
                if(1 == $_SESSION['ifPayed'])
                {
                    $this->profileManager->updateProfile();
                }else{
                    $this->mainController->error();
                }
                break;

            case 'profileDisplay':
                $this->profileManager->displayProfile();
                break;

            case 'processComment':
                $this->commentController->processComment();
                break;

            case 'deleteShop':
                if('staff' == $_SESSION['role'])
                {
                    $this->shopController->deleteShop();
                }
                else{
                    $this->mainController->error();
                }
                break;

            case 'processReview':
                if('staff' == $_SESSION['role'] or 'shop' == $_SESSION['role'])
                {
                    $this->reviewController->processReview();
                }
                else{
                    $this->mainController->error();
                }
                break;

            case 'deleteReview':
                if('staff' == $_SESSION['role'] or 'shop' == $_SESSION['role']) {
                    $this->reviewController->deleteReview();
                }
                else{
                    $this->mainController->error();
                }
                break;

            default:
                $this->mainController->home();

        }
    }
}