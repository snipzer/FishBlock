<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EpisodeController extends Controller
{
    public function showAction(Request $request)
    {
        return $this->render("MainBundle:Episode:show.html.twig");
    }

    public function updateAction(Request $request)
    {
        return $this->render("MainBundle:Episode:update.html.twig");
    }

    public function deleteAction(Request $request)
    {
        return $this->render("MainBundle:Episode:delete.html.twig");
    }

    public function addAction(Request $request)
    {
        return $this->render("MainBundle:Episode:add.html.twig");
    }
}

?>