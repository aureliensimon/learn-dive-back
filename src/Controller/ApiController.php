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
* @Route("/api", name="api_")
*/
class ApiController extends AbstractController {
    
    /**
    * @Route("/profondeurs", name="api_profondeurs")
    */
    public function getAllProfondeurs () {
        $profondeurs = $this->getDoctrine()
            ->getRepository(Profondeur::class)
            ->findApiAll();

        $response = new Response();
    
        $response->setContent(json_encode($profondeurs));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
    * @Route("/profondeur/{target}", name="api_profondeur")
    */
    public function getProfondeur ($target) {
        $profondeur = $this->getDoctrine()
            ->getRepository(Profondeur::class)
            ->findApiByID($target);

        if (!$profondeur) {
            $data = [
                'status' => 404,
                'errors' => "Profondeur not found",
                ];
            return new JsonResponse($data);
        }

        $response = new Response();
    
        $response->setContent(json_encode($profondeur));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
    * @Route("/tables", name="api_tables")
    */
    public function getAllTables () {
        $tables = $this->getDoctrine()
            ->getRepository(TablePlongee::class)
            ->findApiAll();

        $response = new Response();
    
        $response->setContent(json_encode($tables));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
    * @Route("/table/{target}", name="api_table")
    */
    public function getTable ($target) {
        $table = $this->getDoctrine()
            ->getRepository(TablePlongee::class)
            ->findInfos($target);

        if (!$table) {
            $data = [
                'status' => 404,
                'errors' => "Table not found",
                ];
            return new JsonResponse($data);
        }

        $response = new Response();
    
        $response->setContent(json_encode($table));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
    * @Route("/temps", name="api_temps")
    */
    public function getAllTemps () {
        $temps = $this->getDoctrine()
            ->getRepository(Temps::class)
            ->findApiAll();

        $response = new Response();
    
        $response->setContent(json_encode($temps));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
    * @Route("/temps/{target}", name="api_onetemps")
    */
    public function getTemps ($target) {
        $temps = $this->getDoctrine()
            ->getRepository(Temps::class)
            ->findApiByID($target);

        if (!$temps) {
            $data = [
                'status' => 404,
                'errors' => "Table not found",
                ];
            return new JsonResponse($data);
        }

        $response = new Response();
    
        $response->setContent(json_encode($temps));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }
}