<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Profondeur;
use App\Entity\TablePlongee;
use App\Entity\Temps;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/table", name="table_")
*/
class TablePlongeeController extends AbstractController {
    
    /**
    * @Route("/showall", name="table_showall")
    */
    public function showall () {
        $tables = $this->getDoctrine()
            ->getRepository(TablePlongee::class)
            ->findAll();

        return $this->render('tables/index.html.twig', [
            'tables' => $tables,
        ]);
    }

    /**
    * @Route("/delete/{id}", name="table_delete")
    */
    public function delete ($id) {
        $tables = $this->getDoctrine()
            ->getRepository(TablePlongee::class)
            ->findAll();

        return $this->render('tables/index.html.twig', [
            'tables' => $tables,
        ]);
    }


}