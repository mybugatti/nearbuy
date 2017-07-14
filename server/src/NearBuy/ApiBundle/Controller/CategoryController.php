<?php

namespace NearBuy\ApiBundle\Controller;

use NearBuy\ApiBundle\Form\CategoryType;
use NearBuy\DataBundle\Entity\Category;
use NearBuy\DataBundle\Entity\Favourite;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Category controller.
 *
 * @Rest\NamePrefix("nearbuy_api_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * Lists all category entities
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Rest\Get("categories")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('NearBuyDataBundle:Category')->findAll();

        $view = $this->view($categories, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Creates a new category entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\CategoryType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Rest\Post("category")
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('NearBuy\ApiBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $view = $this->view($category, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($category, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a category entity.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Get("category/{id}")
     */
    public function showAction(Category $category)
    {
        $view = $this->view($category, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing category entity.
     * @ApiDoc(
     *   resource = true,
     *   input = "NearBuy\ApiBundle\Form\CategoryType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Put("category/{id}")
     */
    public function editAction(Request $request, Category $category)
    {

        $form = $this->createForm('NearBuy\ApiBundle\Form\CategoryType', $category, array('method' => 'PUT'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $response = new Response();
            return $response;
        }

        return $form;
    }

    /**
     * Deletes a category entity.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the item is not found"
     *   }
     * )
     * @Rest\Delete("category/{id}")
     */
    public function deleteAction(Request $request, Category $category)
    {
        if ($category) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        return $response;
    }
}
