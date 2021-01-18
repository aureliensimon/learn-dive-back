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
    * @Route("/calcul", name="api_calcul", methods={"GET"})
    */
    public function calcul () {

        // VARS (GET FROM FORM)
        $volume_bouteille = $_GET['volumeBouteille'];
        $pression_remplissage =  $_GET['pressionRemplissage'];
        $pr = $_GET['profondeur'];
        $dp = $_GET['dureePlongee'];
        $tableID = $_GET['table'];

        // SETTINGS
        $respiration_moyenne = 20;
        $vitesse_descente = 20;
        $vitesse_remontee_avant_palier = 10;
        $vitesse_remontee_apres_palier = 6;

        // PR CHECK
        $profondeurApproximation = $this->getDoctrine()
            ->getRepository(Profondeur::class)
            ->findProfondeurApproximation($tableID, $pr);
    
        $prA = $profondeurApproximation['profondeur'];
        $prID = $profondeurApproximation['id'];


        // GET PALIERS
        $paliers = $this->getDoctrine()
            ->getRepository(Temps::class)
            ->findTempsApproximation($tableID, $prA, $dp);
        $paliers = $paliers[count($paliers) - 1];
        
        $nombresPaliers = 0;
        $sommePaliers = 0;
        $premier_palier = 0;

        foreach ($paliers as $nom => $palier) {
            if ($palier != 0) {
                $premier_palier = (int) filter_var($nom, FILTER_SANITIZE_NUMBER_INT);
                $nombresPaliers += 1;
                $sommePaliers += $palier;
            }
        }

        $dtr = 1/2 * $nombresPaliers + $sommePaliers + 1/10 * ($pr - $premier_palier);
        $dtp = $dp + $dtr;

        $consoProfondeur = 1 + $pr / 10;
        $consoMoyenne = (1 + $consoProfondeur) / 2;
        $tempsDescente = $pr / $vitesse_descente;
        $volume_total = $volume_bouteille * $pression_remplissage;
        $volumeRestant = $volume_total - (($tempsDescente * $consoMoyenne) + ($dp * $consoProfondeur)) * $respiration_moyenne;
        $pressionRestante = $volumeRestant / $volume_bouteille;

        $res = array();
        $res['tempsTotalDeRemontee'] = $dtr;
        $res['tempsTotalDePlongee'] = $dtp;
        $res['volumeRestant'] = round($volumeRestant);
        $res['pressionRestante'] = round($pressionRestante);
        $res['paliers'] = $paliers;

        $response = new Response();

        $response->setContent(json_encode($res));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
        
    }
}