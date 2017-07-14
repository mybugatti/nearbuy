<?php

namespace NearBuy\SiteBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use NearBuy\DataBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('NearBuySiteBundle:Default:index.html.twig');
    }

    /**
     * @Route("/help/")
     */
    public function helpAction()
    {
        return $this->render('NearBuySiteBundle:Default:help.html.twig');
    }

    /**
     *
     * @param Request $request
     * @return Response
     * @Route("/register/")
     */
    public function registerAction(Request $request)
    {
        return $this->forward('NearBuySiteBundle:Account:register', array(
            'request' => $request,
            'isBusiness' => false
        ));
    }

    /**
     *
     * @param Request $request
     * @return Response
     * @Route("/login/")
     */
    public function loginAction(Request $request)
    {
        return $this->forward('NearBuySiteBundle:Account:login', array(
            'request' => $request
        ));
    }
}
