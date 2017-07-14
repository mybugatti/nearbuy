<?php

namespace NearBuy\SiteBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use NearBuy\DataBundle\Entity\Favourite;
use NearBuy\DataBundle\Entity\Settings;
use NearBuy\DataBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

/**
 * Controller managing the user profile.
 *
 */
class AccountController extends Controller
{
    /**
     * Show the user.
     *
     * @Route("/")
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            $this->redirectToRoute("nearbuy_site_default_index");
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('NearBuySiteBundle:Account:show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Edit the user.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/edit/")
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('nearbuy_site_account_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('NearBuySiteBundle:Account:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Edit user settings.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/settings/")
     */
    public function settingsAction(Request $request){
        /** @var User $user */
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $settings = $user->getSettings();

        if (!is_object($settings) || !$settings instanceof Settings) {
            $settings = new Settings();
            $user->setSettings($settings);
        }

        $form = $this->createForm('NearBuy\SiteBundle\Form\SettingsType', $settings);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($settings);
            $em->persist($user);
            $em->flush();

            return new RedirectResponse($this->generateUrl('nearbuy_site_account_show'));
        }

        return $this->render('NearBuySiteBundle:Account:settings.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Edit the user favorite categories.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/categories/")
     */
    public function categoriesAction(Request $request){
        /** @var User $user */
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();

        $favCategories = $user->getFavouriteCategories();
        $categories = array();
        foreach($em->getRepository("NearBuyDataBundle:Category")->findAll() as $category){
            $category = $category->toArray();
            $category["value"] = in_array($category["id"],$favCategories->toArray());
            array_push($categories, $category);
        }

        $formBuilder = $this->createFormBuilder();

        foreach ($categories as $category){
            $formBuilder->add("category_".$category["id"],
                CheckboxType::class,
                array('label'=> $category["name"], 'data' => $category["value"], 'required' => false));
        }

        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($request->getMethod() == "POST") {

            //submited categories (as id array)
            $subCategories = array();
            foreach($request->request->get("form")as $name=>$value){
                if(strpos($name,"category_") !== false && $value == true){
                    array_push($subCategories, (int)str_replace("category_","",$name));
                }
            }


            //remove favourites categories
            foreach($favCategories as $favCategory){
                if(!in_array($favCategory,$subCategories)){
                    foreach ($em->getRepository("NearBuyDataBundle:Favourite")->findBy(array("category"=>$favCategory,"user"=>$user)) as $tmp){
                        $em->remove($tmp);
                    };
                }

            }

            //add favourites categories
            foreach($subCategories as $category){
                if(count($em->getRepository("NearBuyDataBundle:Favourite")->findBy(array("category"=>$category,"user"=>$user)))<1){
                    $favCategory = new Favourite();
                    $favCategory->setUser($user);
                    $favCategory->setCategory($em->getRepository("NearBuyDataBundle:Category")->find($category));
                    $em->persist($favCategory);
                }

            }

            $em->flush();

            return new RedirectResponse($this->generateUrl('nearbuy_site_account_categories'));
        }

        return $this->render('NearBuySiteBundle:Account:categories.html.twig', array(
            //'categories' => $categories,
            'form' => $form->createView()
        ));
    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request, $isBusiness = false)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        /** @var $user User*/
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->setBusiness($isBusiness);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                //associated settings creation
                $setting = new Settings();
                $setting->setUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('nearbuy_site_account_registered');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('NearBuySiteBundle:Account:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->render('NearBuySiteBundle:Account:login.html.twig',array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     *
     * @param Request $request
     * @return Response
     * @Route("/registered/")
     */
    public function registeredAction(Request $request){
        return $this->render('NearBuySiteBundle:Account:registered.html.twig');
    }

    /**
     * Change user password.
     *
     * @param Request $request
     *
     * @return Response
     * @Route("/change_password/")
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('nearbuy_site_account_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('NearBuySiteBundle:Account:change_password.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Change user password.
     *
     * @param Request $request
     *
     * @return Response
     * @Route("/delete/")
     */
    public function deleteAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->createForm('NearBuy\SiteBundle\Form\SecurityType', $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $userManager->deleteUser($user);

            return new RedirectResponse($this->generateUrl('nearbuy_site_default_index'));
        }

        return $this->render('NearBuySiteBundle:Account:delete.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
