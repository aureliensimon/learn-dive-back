<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Profondeur;
use App\Entity\profondeurPlongee;
use App\Entity\Temps;

use App\Form\ProfondeurType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/profondeur", name="profondeur_")
*/
class ProfondeurController extends AbstractController {
    
    /**
    * @Route("/show", name="show")
    */
    public function show () {
        $profondeurs = $this->getDoctrine()
            ->getRepository(Profondeur::class)
            ->findAll();

        return $this->render('profondeurs/index.html.twig', [
            'profondeurs' => $profondeurs,
        ]);
    }

    /**
    * @Route("/delete/{target}", name="delete")
    */
    public function delete (Profondeur $target) {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($target);
        $entityManager->flush();

        return $this->redirectToRoute('profondeur_show');
    }

    /**
    * @Route("/create", name="create")
    */
    public function create (Request $request) {

        $form = $this->createForm(ProfondeurType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ProfondeurFormData = $form->getData();

            $newProfondeur = new Profondeur();
            
            $newProfondeur->setProfondeur($ProfondeurFormData->getProfondeur());
            $newProfondeur->setTablePlongeeId($ProfondeurFormData->getTablePlongeeId());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newProfondeur);
            $entityManager->flush();

            return $this->redirectToRoute('profondeur_show');
        }

        return $this->render('profondeurs/form.html.twig', [
            'form' => $form->createView(),
        ]); 
    }

    /**
    * @Route("/edit/{target}", name="edit")
    */
    public function edit ($target, Request $request) {

        $target_element = $this->getDoctrine()
                            ->getRepository(Profondeur::class)
                            ->find($target);

        $form = $this->createForm(ProfondeurType::class, $target_element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ProfondeurFormData = $form->getData();

            $newProfondeur = new Profondeur();
            
            $newProfondeur->setProfondeur($ProfondeurFormData->getProfondeur());
            $newProfondeur->setTablePlongeeId($ProfondeurFormData->getTablePlongeeId());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newProfondeur);
            $entityManager->flush();

            return $this->redirectToRoute('profondeur_show');
        }

        return $this->render('profondeurs/form.html.twig', [
            'form' => $form->createView(),
        ]); 
    }


}