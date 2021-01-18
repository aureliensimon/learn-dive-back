<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Profondeur;
use App\Entity\TablePlongee;
use App\Entity\Temps;

use App\Form\TempsType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/temps", name="temps_")
*/
class TempsController extends AbstractController {
    
    /**
    * @Route("/show", name="show")
    */
    public function show () {
        $temps = $this->getDoctrine()
            ->getRepository(Temps::class)
            ->findAll();

        return $this->render('temps/index.html.twig', [
            'temps' => $temps,
        ]);
    }

    /**
    * @Route("/delete/{target}", name="delete")
    */
    public function delete (Temps $target) {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($target);
        $entityManager->flush();

        return $this->redirectToRoute('temps_show');
    }

    /**
    * @Route("/create", name="create")
    */
    public function create (Request $request) {

        $form = $this->createForm(TempsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tempsFormData = $form->getData();

            $newTemps = new Temps();

            $newTemps->setTemps($tempsFormData->getTemps());
            
            $newTemps->setPalier3($tempsFormData->getPalier3());
            $newTemps->setPalier6($tempsFormData->getPalier6());
            $newTemps->setPalier9($tempsFormData->getPalier9());
            $newTemps->setPalier12($tempsFormData->getPalier12());
            $newTemps->setPalier15($tempsFormData->getPalier15());

            $newTemps->setProfondeurId($tempsFormData->getProfondeurId());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newTemps);
            $entityManager->flush();

            return $this->redirectToRoute('temps_show');
        }

        return $this->render('temps/form.html.twig', [
            'form' => $form->createView(),
        ]); 
    }

    /**
    * @Route("/edit/{target}", name="edit")
    */
    public function edit ($target, Request $request) {

        $target_element = $this->getDoctrine()
                            ->getRepository(Temps::class)
                            ->find($target);

        $form = $this->createForm(TempsType::class, $target_element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tempsFormData = $form->getData();

            $newTemps = new Temps();

            $newTemps->setTemps($tempsFormData->getTemps());
            
            $newTemps->setPalier3($tempsFormData->getPalier3());
            $newTemps->setPalier6($tempsFormData->getPalier6());
            $newTemps->setPalier9($tempsFormData->getPalier9());
            $newTemps->setPalier12($tempsFormData->getPalier12());
            $newTemps->setPalier15($tempsFormData->getPalier15());

            $newTemps->setProfondeurId($tempsFormData->getProfondeurId());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newTemps);
            $entityManager->flush();

            return $this->redirectToRoute('temps_show');
        }

        return $this->render('temps/form.html.twig', [
            'form' => $form->createView(),
        ]); 
    }


}