<?php

namespace NearBuy\ApiBundle\Controller;

use NearBuy\DataBundle\Entity\Employment;
use NearBuy\DataBundle\Entity\Entreprise;
use NearBuy\DataBundle\Type\EmploymentRoleType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Entreprise controller.
 *
 * @Rest\NamePrefix("nearbuy_api_entreprise_")
 */
class EntrepriseController extends AbstractController
{
    /**
     * Lists all entreprise entities
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Rest\Get("entreprises")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entreprises = $em->getRepository('NearBuyDataBundle:Entreprise')->findAll();

        $view = $this->view($entreprises, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Creates a new entreprise entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\EntrepriseType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("entreprise")
     */
    public function newAction(Request $request)
    {
        $entreprise = new Entreprise();
        $form = $this->createForm('NearBuy\ApiBundle\Form\EntrepriseType', $entreprise);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);

            foreach($entreprise->getEntrepriseCategory() as $entrepriseCategory){
                $entrepriseCategory->setEntreprise($entreprise);
                $em->persist($entrepriseCategory);
            }

            //set user as CEO
            $employment = new Employment();
            $employment->setEntreprise($entreprise);
            $employment->setUser($this->getUser());
            $employment->setRole(EmploymentRoleType::CEO);

            $em->persist($employment);

            $em->flush();

            $view = $this->view($entreprise, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($entreprise, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a entreprise entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("entreprise/{id}")
     */
    public function showAction(Entreprise $entreprise)
    {
        $view = $this->view($entreprise, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing entreprise entity.
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\EntrepriseType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Put("entreprise/{id}")
     */
    public function editAction(Request $request, Entreprise $entreprise)
    {
        $form = $this->createForm('NearBuy\ApiBundle\Form\EntrepriseType', $entreprise, array('method' => 'PUT'));

        $em = $this->getDoctrine()->getManager();
        foreach($entreprise->getEntrepriseCategory() as $entrepriseCategory) {
            $em->remove($entrepriseCategory);
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entreprise);

            foreach($entreprise->getEntrepriseCategory() as $entrepriseCategory){
                $entrepriseCategory->setEntreprise($entreprise);
                $em->persist($entrepriseCategory);
            }

            $em->flush();

            $response = new Response();
            return $response;
        }

        return $form;
    }

    /**
     * Deletes a entreprise entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("entreprise/{id}")
     */
    public function deleteAction(Request $request, Entreprise $entreprise)
    {
        if ($entreprise) {
            $em = $this->getDoctrine()->getManager();

            foreach($entreprise->getEntrepriseCategory() as $entrepriseCategory){
                $em->remove($entrepriseCategory);
            }

            foreach($entreprise->getEmployments() as $employment){
                $em->remove($employment);
            }

            $em->remove($entreprise);
            $em->flush();
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }

    /**
     * Lists all entreprise employments
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Rest\Get("entreprise/{id}/employments")
     */
    public function indexEmploymentsAction(Entreprise $entreprise)
    {
        $em = $this->getDoctrine()->getManager();

        $employments = $em->getRepository('NearBuyDataBundle:Employment')->findByEntreprise($entreprise);

        $view = $this->view($employments, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Creates a new entreprise employment.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\EmploymentType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("entreprise/{id}/employment")
     */
    public function newEmploymentAction(Request $request, Entreprise $entreprise)
    {
        if($entreprise){
            $employment = new Employment();
            $employment->setEntreprise($entreprise);
            $form = $this->createForm('NearBuy\ApiBundle\Form\EmploymentType', $employment);
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($employment);
                $em->flush();

                $view = $this->view($employment, Response::HTTP_OK);
                return $this->handleView($view);
            }

            $view = $this->view($employment, Response::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }

    /**
     * Finds and displays a entreprise entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("employment/{id}")
     */
    public function showEmploymentAction(Employment $employment)
    {
        $view = $this->view($employment, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Edit a employment entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\EmploymentType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Put("employment/{id}")
     */
    public function editEmploymentAction(Request $request, Employment $employment)
    {
        if($employment){
            $form = $this->createForm('NearBuy\ApiBundle\Form\EmploymentType', $employment, array('method' => 'PUT'));
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($employment);
                $em->flush();

                $view = $this->view($employment, Response::HTTP_OK);
                return $this->handleView($view);
            }

            $view = $this->view($employment, Response::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }

    /**
     * Deletes a employment entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("employment/{id}")
     */
    public function deleteEmploymentAction(Request $request, Employment $employment)
    {
        if ($employment) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($employment);
            $em->flush();
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }
}
