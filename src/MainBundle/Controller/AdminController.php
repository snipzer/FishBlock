<?php
namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function homeAction(Request $request)
    {
        return $this->render("MainBundle:Admin:home.html.twig");
    }

    public function validateAction(Request $request)
    {
        return $this->render("MainBundle:Admin:validate.html.twig");
    }

    public function updateUserAction(Request $request)
    {
        return $this->render("MainBundle:Admin:updateUser.html.twig");
    }
}
?>