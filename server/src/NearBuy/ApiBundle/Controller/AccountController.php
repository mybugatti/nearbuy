<?php

namespace NearBuy\ApiBundle\Controller;

use FOS\UserBundle\Command\RoleCommand;
use NearBuy\ApiBundle\Form\AccountType;
use NearBuy\DataBundle\Entity\Category;
use NearBuy\DataBundle\Entity\Entreprise;
use NearBuy\DataBundle\Entity\User;
use NearBuy\DataBundle\Entity\UserDescription;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Account controller.
 *
 * @Rest\NamePrefix("nearbuy_api_account_")
 */
class AccountController extends AbstractController
{
    /**
     * User registration.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\AccountType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("register")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('NearBuy\ApiBundle\Form\AccountType', $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $user->setEnabled(1);

            if($user->isBusiness()){
                $user->setRoles(array('ROLE_BUSINESS'));
            }
            $em->persist($user);

            /**
             * Force user reference in descriptions
             * @var UserDescription $description
             */
            foreach ($user->getDescriptions() as $description){
                $description->setUser($user);
                $em->persist($description);
            }
            $em->flush();

            $view = $this->view($user, Response::HTTP_OK);

            return $this->handleView($view);
        }

        $view = $this->view($user, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a account entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("account")
     */
    public function showAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->forward('NearBuyApiBundle:User:show', array(
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing account entity.
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\AccountType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Put("account")
     */
    public function editAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('NearBuy\ApiBundle\Form\AccountType', $user, array('method' => 'PUT'));
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
     * Deletes a account entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("account")
     */
    public function deleteAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->forward('NearBuyApiBundle:User:delete', array(
            'user' => $user
        ));
    }

    /**
     * Add category to favourites.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("account/favouritecategory/{id}")
     */
    public function newFavouriteCategoryAction(Category $category){
        $em = $this->getDoctrine()->getManager();

        /** @var $user User*/
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user->addFavouriteCategory($category);
        $em->persist($category);
        $em->flush();

        $response = new Response();
        return $response->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove category from favourites.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Delete("account/favouritecategory/{id}")
     */
    public function deleteFavouriteCategoryAction(Category $category){
        $em = $this->getDoctrine()->getManager();

        /** @var $user User*/
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $collection = $user->removeFavouriteCategory($category);
        foreach ($collection as $key => $favourite){
            $em->remove($favourite);
        }
        $em->flush();

        $response = new Response();
        return $response->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Add entreprise to favourites.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("account/favouriteentreprise/{id}")
     */
    public function newFavouriteEntrepriseAction(Entreprise $entreprise){
        $em = $this->getDoctrine()->getManager();

        /** @var $user User*/
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user->addFavouriteEntreprise($entreprise);
        $em->persist($entreprise);
        $em->flush();

        $response = new Response();
        return $response->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove entreprise from favourites.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Delete("account/favouriteentreprise/{id}")
     */
    public function deleteFavouriteEntrepriseAction(Entreprise $entreprise){
        $em = $this->getDoctrine()->getManager();

        /** @var $user User*/
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $collection = $user->removeFavouriteEntreprise($entreprise);
        foreach ($collection as $key => $favourite){
            $em->remove($favourite);
        }
        $em->flush();

        $response = new Response();
        return $response->setStatusCode(Response::HTTP_OK);
    }
}
