<?php

namespace NearBuy\ApiBundle\Controller;

use NearBuy\DataBundle\Entity\Diffusion;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Diffusion controller.
 *
 * @Rest\NamePrefix("nearbuy_api_diffusion_")
 */
class DiffusionController extends AbstractController
{
    /**
     * Lists all diffusion entities
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Rest\Get("diffusions")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $diffusions = $em->getRepository('NearBuyDataBundle:Diffusion')->findAll();

        $view = $this->view($diffusions, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Creates a new diffusion entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\DiffusionType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("diffusion")
     */
    public function newAction(Request $request)
    {
        $diffusion = new Diffusion();
        $form = $this->createForm('NearBuy\ApiBundle\Form\DiffusionType', $diffusion);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($diffusion);

            foreach($diffusion->getDiffusionLocal() as $diffusionLocal){
                $diffusionLocal->setDiffusion($diffusion);
                $em->persist($diffusionLocal);
            }

            $em->flush();

            $view = $this->view($diffusion, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($diffusion, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a diffusion entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("diffusion/{id}")
     */
    public function showAction(Diffusion $diffusion)
    {
        $view = $this->view($diffusion, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing diffusion entity.
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\DiffusionType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Put("diffusion/{id}")
     */
    public function editAction(Request $request, Diffusion $Diffusion)
    {
        $form = $this->createForm('NearBuy\ApiBundle\Form\DiffusionType', $Diffusion, array('method' => 'PUT'));

        $em = $this->getDoctrine()->getManager();
        foreach($Diffusion->getDiffusionLocal() as $diffusionLocal) {
            $em->remove($diffusionLocal);
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Diffusion);

            foreach($Diffusion->getDiffusionLocal() as $diffusionLocal){
                $diffusionLocal->setDiffusion($Diffusion);
                $em->persist($diffusionLocal);
            }

            $em->flush();

            $response = new Response();
            return $response;
        }

        return $form;
    }

    /**
     * Deletes a diffusion entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("diffusion/{id}")
     */
    public function deleteAction(Request $request, Diffusion $diffusion)
    {
        if ($diffusion) {
            $em = $this->getDoctrine()->getManager();

            foreach($diffusion->getDiffusionLocal() as $diffusionLocal){
                $em->remove($diffusionLocal);
            }

            $em->remove($diffusion);
            $em->flush();
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }
}
