<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{

    /**
     * Fonction appeller grâce à la route comment_post
     * Sont rôle est d'envoyer une critique en base de données dans la table Critic
     */
    public function postAction(Request $request)
    {
        return new Response("Envois de commentaire");
    }

    /**
     * Fonction appeller grâce à la route comment_update
     * Sont rôle est de mettre a jour une critique dans la table Critic
     * L'id de la critique est récupérer via l'url
     */
    public function updateAction(Request $request)
    {
        return new Response("Modification d'un commentaire");
    }

    /**
     * Fonction appeller grâce à la route comment_delete
     * Sont rôle est de supprimer une critique via sont id récupérer via l'url
     */
    public function deleteAction(Request $request)
    {
        return new Response("Supression d'un commentaire");
    }
}

?>