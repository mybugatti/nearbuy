<?php

namespace NearBuy\ApiBundle\Controller;

use NearBuy\DataBundle\Entity\Promotion;
use NearBuy\DataBundle\Entity\User;
use NearBuy\DataBundle\Entity\UserPromotion;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Rest\NamePrefix("nearbuy_api_user_")
 */
class UserController extends AbstractController
{
    /**
     * Lists all user entities
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Rest\Get("users")
     * @Rest\View(serializerGroups={"user"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('NearBuyDataBundle:User')->findAll();

        $view = $this->view($users, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Creates a new user entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\UserType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("user")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('NearBuy\ApiBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $view = $this->view($user, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($user, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a user entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("user/{id}")
     */
    public function showAction(User $user)
    {
        $view = $this->view($user, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing user entity.
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\UserType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Put("user/{id}")
     */
    public function editAction(Request $request, User $user)
    {

        $form = $this->createForm('NearBuy\ApiBundle\Form\UserType', $user, array('method' => 'PUT'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $response = new Response();
            return $response;
        }

        return $form;
    }

    /**
     * Deletes a user entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("user/{id}")
     */
    public function deleteAction(Request $request, User $user)
    {
        if ($user) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }

    /**
     * Creates a new user entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("user/{id}/promotionusage/{promotion}")
     */
    public function newPromotionUsageAction(User $user, Promotion $promotion)
    {
        if ($user && $promotion) {

            $em = $this->getDoctrine()->getManager();

            /** @var $promotionUsages array */
            $promotionUsages = $em->getRepository('NearBuyDataBundle:UserPromotion')->findBy(array('user' => $user, 'promotion' => $promotion));

            /* if no or multiple usage of this promotion, creates a new unique usage*/
            if(count($promotionUsages)>1||1>count($promotionUsages)){
                $nbUsed = 0;
                foreach ($promotionUsages as $promotionUsage){
                    /** @var $promotionUsage UserPromotion */
                    $nbUsed += $promotionUsage->getNbUsed();
                    $em->remove($promotionUsage);
                }
                $promotionUsage = new UserPromotion();
                $promotionUsage->setPromotion($promotion);
                $promotionUsage->setUser($user);
                $promotionUsage->setNbUsed($nbUsed);
            }
            else{
                $promotionUsage = $promotionUsages[0];
            }
            $promotionUsage->incrementNbUsed();

            $em->persist($promotionUsage);
            $em->flush();

            $response = new Response();
            $response->setStatusCode(Response::HTTP_OK);
            return $response;

        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }
}
