<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Profondeur;
use App\Entity\TablePlongee;
use App\Entity\Temps;

use App\Form\TablePlongeeType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/table", name="table_")
*/
class TablePlongeeController extends AbstractController {
    
    /**
    * @Route("/show", name="show")
    */
    public function show () {
        $tables = $this->getDoctrine()
            ->getRepository(TablePlongee::class)
            ->findAll();

        return $this->render('tables/index.html.twig', [
            'tables' => $tables,
        ]);
    }

    /**
    * @Route("/delete/{target}", name="delete")
    */
    public function delete (TablePlongee $target) {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($target);
        $entityManager->flush();

        return $this->redirectToRoute('table_show');
    }

    /**
    * @Route("/create", name="create")
    */
    public function create (Request $request) {

        $form = $this->createForm(TablePlongeeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $TablePlongeeFormData = $form->getData();

            $newTablePlongee = new TablePlongee();
            
            $newTablePlongee->setNom($TablePlongeeFormData->getNom());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newTablePlongee);
            $entityManager->flush();

            return $this->redirectToRoute('table_show');
        }

        return $this->render('tables/form.html.twig', [
            'form' => $form->createView(),
        ]); 
    }

    /**
    * @Route("/edit/{target}", name="edit")
    */
    public function edit ($target, Request $request) {

        $target_element = $this->getDoctrine()
                            ->getRepository(TablePlongee::class)
                            ->find($target);

        $form = $this->createForm(TablePlongeeType::class, $target_element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $TablePlongeeFormData = $form->getData();

            $newTablePlongee = new TablePlongee();
            
            $newTablePlongee->setNom($TablePlongeeFormData->getNom());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newTablePlongee);
            $entityManager->flush();

            return $this->redirectToRoute('table_show');
        }

        return $this->render('tables/form.html.twig', [
            'form' => $form->createView(),
        ]); 
    }


}