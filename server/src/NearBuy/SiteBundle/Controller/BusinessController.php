<?php

namespace NearBuy\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BusinessController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('NearBuySiteBundle:Business:index.html.twig');
    }

    /**
     * @Route("/help/")
     */
    public function helpAction()
    {
        return $this->render('NearBuySiteBundle:Business:help.html.twig');
    }

    /**
     * @Route("/register/")
     */
    public function registerAction()
    {

    }

    /**
     * @Route("/login/")
     */
    public function loginAction()
    {

    }
}
