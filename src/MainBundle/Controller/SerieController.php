<?php
namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SerieController extends Controller
{


    /**
     * Appeler quand l'utilisateur veux rechercher une série
     *
     * Par défault l'utilisateur arrive sur une page qui affiche les séries les plus populaires
     *
     * Si la série que l'utilisateur cherche n'existe pas, alors on lui propose de la créer (envois sur addAction)
     */
    public function searchAction(Request $request)
    {
        return $this->render("MainBundle:Serie:search.html.twig");
    }

    public function showAction(Request $request)
    {
        return $this->render("MainBundle:Serie:show.html.twig");
    }

    public function updateAction(Request $request)
    {
        return $this->render("MainBundle:Serie:update.html.twig");
    }

    public function deleteAction(Request $request)
    {
        return $this->render("MainBundle:Serie:delete.html.twig");
    }

    public function addAction(Request $request)
    {
        return $this->render("MainBundle:Serie:add.html.twig");
    }
}

?>