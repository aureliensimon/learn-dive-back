<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class HomepageController extends AbstractController {
    
    /**
    * @Route("/", name="homepage")
    */
    public function index () {

        return $this->render('homepage/index.html.twig', [
        ]);
    }
}