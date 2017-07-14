<?php

namespace NearBuy\ApiBundle\Controller;

use NearBuy\ApiBundle\Security\AbstractVoter;
use NearBuy\DataBundle\Entity\Promotion;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Promotion controller.
 *
 * @Rest\NamePrefix("nearbuy_api_promotion_")
 */
class PromotionController extends AbstractController
{
    /**
     * Lists all promotion entities
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Rest\Get("promotions")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $promotions = $em->getRepository('NearBuyDataBundle:Promotion')->findAll();

        $view = $this->view($promotions, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Creates a new promotion entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\PromotionType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("promotion")
     */
    public function newAction(Request $request)
    {
        $promotion = new Promotion();
        $form = $this->createForm('NearBuy\ApiBundle\Form\PromotionType', $promotion);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();

            $view = $this->view($promotion, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($promotion, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a promotion entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("promotion/{id}")
     */
    public function showAction(Promotion $promotion)
    {
        /*var_dump($this->getUser());
        exit();*/
        $this->denyAccessUnlessGranted(AbstractVoter::SHOW, $promotion);

        $view = $this->view($promotion, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing promotion entity.
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\PromotionType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Put("promotion/{id}")
     */
    public function editAction(Request $request, Promotion $promotion)
    {
        $this->denyAccessUnlessGranted(AbstractVoter::EDIT, $promotion);

        $form = $this->createForm('NearBuy\ApiBundle\Form\PromotionType', $promotion, array('method' => 'PUT'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();

            $response = new Response();
            return $response;
        }

        return $form;
    }

    /**
     * Deletes a promotion entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("promotion/{id}")
     */
    public function deleteAction(Request $request, Promotion $promotion)
    {
        if ($promotion) {
            $this->denyAccessUnlessGranted(AbstractVoter::DELETE, $promotion);

            $em = $this->getDoctrine()->getManager();

            foreach($promotion->getDiffusions() as $diffusion){
                foreach($diffusion->getDiffusionLocal() as $diffusionLocal){
                    $em->remove($diffusionLocal);
                }
                $em->remove($diffusion);
            }

            $em->remove($promotion->getReduction());
            $em->remove($promotion);
            $em->flush();
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }
}
