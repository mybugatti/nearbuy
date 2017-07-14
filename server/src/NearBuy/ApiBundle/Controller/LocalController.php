<?php

namespace NearBuy\ApiBundle\Controller;

use NearBuy\DataBundle\Entity\Local;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Local controller.
 *
 * @Rest\NamePrefix("nearbuy_api_local_")
 */
class LocalController extends AbstractController
{
    /**
     * Lists all local entities
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Rest\Get("locals")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $locals = $em->getRepository('NearBuyDataBundle:Local')->findAll();

        $view = $this->view($locals, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Creates a new local entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\LocalType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("local")
     */
    public function newAction(Request $request)
    {
        $local = new Local();
        $form = $this->createForm('NearBuy\ApiBundle\Form\LocalType', $local);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($local);
            $em->flush();

            $view = $this->view($local, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($local, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a local entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("local/{id}")
     */
    public function showAction(Local $local)
    {
        $view = $this->view($local, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing local entity.
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\LocalType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Put("local/{id}")
     */
    public function editAction(Request $request, Local $local)
    {

        $form = $this->createForm('NearBuy\ApiBundle\Form\LocalType', $local, array('method' => 'PUT'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($local);
            $em->flush();

            $response = new Response();
            return $response;
        }

        return $form;
    }

    /**
     * Deletes a local entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("local/{id}")
     */
    public function deleteAction(Request $request, Local $local)
    {
        if ($local) {
            $em = $this->getDoctrine()->getManager();

            foreach($local->getDiffusionLocal() as $diffusionLocal){
                $em->remove($diffusionLocal);
            }

            $em->remove($local);
            $em->flush();
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }
}
