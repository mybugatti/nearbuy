<?php

namespace NearBuy\ApiBundle\Controller;

use NearBuy\DataBundle\Entity\Reduction;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Reduction controller.
 *
 * @Rest\NamePrefix("nearbuy_api_reduction_")
 */
class ReductionController extends BaseController
{
    /**
     * Lists all reduction entities
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Rest\Get("reductions")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reductions = $em->getRepository('NearBuyDataBundle:Reduction')->findAll();

        $view = $this->view($reductions, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * Creates a new reduction entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\ReductionType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("reduction")
     */
    public function newAction(Request $request)
    {
        $reduction = new Reduction();
        $form = $this->createForm('NearBuy\ApiBundle\Form\ReductionType', $reduction);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($reduction);
            $em->flush();

            $view = $this->view($reduction, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($reduction, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a reduction entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("reduction/{id}")
     */
    public function showAction(Reduction $reduction)
    {
        $view = $this->view($reduction, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing reduction entity.
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\ReductionType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Put("reduction/{id}")
     */
    public function editAction(Request $request, Reduction $reduction)
    {

        $form = $this->createForm('NearBuy\ApiBundle\Form\ReductionType', $reduction, array('method' => 'PUT'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reduction);
            $em->flush();

            $response = new Response();
            return $response;
        }

        return $form;
    }

    /**
     * Deletes a reduction entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("reduction/{id}")
     */
    public function deleteAction(Request $request, Reduction $reduction)
    {
        if ($reduction) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reduction);
            $em->flush();
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }
}
