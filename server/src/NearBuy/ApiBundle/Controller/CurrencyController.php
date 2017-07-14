<?php

namespace NearBuy\ApiBundle\Controller;

use NearBuy\DataBundle\Entity\Currency;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Currency controller.
 *
 * @Rest\NamePrefix("nearbuy_api_currency_")
 */
class CurrencyController extends AbstractController
{
    /**
     * Lists all currency entities
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Rest\Get("currencies")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $currencies = $em->getRepository('NearBuyDataBundle:Currency')->findAll();

        $view = $this->view($currencies, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Creates a new currency entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\CurrencyType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("currency")
     */
    public function newAction(Request $request)
    {
        $currency = new Currency();
        $form = $this->createForm('NearBuy\ApiBundle\Form\CurrencyType', $currency);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($currency);
            $em->flush();

            $view = $this->view($currency, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($currency, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a currency entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("currency/{id}")
     */
    public function showAction(Currency $currency)
    {
        $view = $this->view($currency, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing currency entity.
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\CurrencyType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Put("currency/{id}")
     */
    public function editAction(Request $request, Currency $currency)
    {
        $deleteForm = $this->createDeleteForm($currency);
        $editForm = $this->createForm('NearBuy\ApiBundle\Form\CurrencyType', $currency);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('currency_edit', array('id' => $currency->getId()));
        }

        return $this->render('currency/edit.html.twig', array(
            'currency' => $currency,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a currency entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("currency/{id}")
     */
    public function deleteAction(Request $request, Currency $currency)
    {
        if ($currency) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($currency);
            $em->flush();
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }
}
