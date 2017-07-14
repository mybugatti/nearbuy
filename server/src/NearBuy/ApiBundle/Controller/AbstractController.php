<?php

namespace NearBuy\ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;

class AbstractController extends BaseController{

    public function handleView(View $view)
    {
        $view->setContext($view->getContext()->setGroups([$this->getEntityName()])->enableMaxDepth());
        return parent::handleView($view);
    }

    public function getEntityName(){
        return strtolower(substr(substr(strrchr(get_class($this), "\\"), 1), 0, -10));
    }
}
