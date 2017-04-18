<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function postAction(Request $request)
    {
        return new Response("Envois de commentaire");
    }

    public function updateAction(Request $request)
    {
        return new Response("Modification d'un commentaire");
    }

    public function deleteAction(Request $request)
    {
        return new Response("Supression d'un commentaire");
    }
}

?>