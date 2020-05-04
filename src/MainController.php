<?php

namespace Tudublin;

class MainController
{
    private $twig;
    private $dB;
    private $error = [];

    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->dB = new Db();

    }
    //home page
    public function home()
    {
        $templates = 'home.html.twig';
        $args=['role'=> $_SESSION['role'],
                'ifPayed'=> $_SESSION['ifPayed'],
                'userName'=> $_SESSION['userName']
            ];
        $html = $this->twig->render($templates, $args);

        print $html;
    }
    //about page
    public function about()
    {
        $templates = 'about.html.twig';
        $args = ['role'=> $_SESSION['role'],
                'ifPayed'=> $_SESSION['ifPayed'],
                'userName'=> $_SESSION['userName']
            ];
        $html = $this->twig->render($templates, $args);

        print $html;
    }
    //comments, review, shops page
    public function review($error = [])
    {
        $templates = 'review.html.twig';
        $args=['shop' =>$this->dB->getAllShops(),
                'comment' => $this->dB->getAllComment(),
                'review' =>$this->dB->getAllReview(),
               'role'=> $_SESSION['role'],
                'ifPayed'=> $_SESSION['ifPayed'],
                'userName'=> $_SESSION['userName'],
                'error' => $error
              ];

        $html = $this->twig->render($templates, $args);

        print $html;
    }
    //login page
    public function login($error)
    {
        $templates = 'login.html.twig';
        $args=['errors' => $error,
               'role'=> $_SESSION['role']
              ];
        $html = $this->twig->render($templates, $args);

        print $html;
    }
    //on log out will null all sessions
    public function logOut()
    {
        $_SESSION['role'] = null;
        $_SESSION['userName'] = null;
        $_SESSION['ifPayed'] = null;

        $this->login($this->error);
    }
    //for unauthorize access
    public function error()
    {
        $templates = 'error.html.twig';
        $args=['role'=> $_SESSION['role']];
        $html = $this->twig->render($templates, $args);

        print $html;
    }
    //manage manage acc only for admin role
    public function secret($error = null, $delete =null)
    {
        $templates = 'secret.html.twig';
        $args = ['role'=> $_SESSION['role'],
                'ifPayed'=> $_SESSION['ifPayed'],
                'userName'=> $_SESSION['userName'],
                'error' => $error,
                'delete' => $delete
        ];
        $html = $this->twig->render($templates, $args);

        print $html;
    }
    //create profile page
    public function profile($acc)
    {
        $templates = 'profile.html.twig';
        $args=['ifPayed'=> $_SESSION['ifPayed'],
            'role'=> $_SESSION['role'],
            'account' => $acc
        ];

        $html = $this->twig->render($templates, $args);

        print $html;
    }
    //display profile on selected user
    public function profileDisplay($acc)
    {
        $templates = 'displayProfile.html.twig';
        $args=['ifPayed'=> $_SESSION['ifPayed'],
            'role'=> $_SESSION['role'],
            'account' => $acc];
        $html = $this->twig->render($templates, $args);

        print $html;
    }

}