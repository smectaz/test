<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Services\appelFacture;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FactureController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/facture', name: 'app_facture')]
    public function edition(appelFacture $appel, FactureRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $factures = $appel->findAll($repository, $paginator, $request);

        return $this->render('facture/index.html.twig', [
            'factures' => $factures
        ]);
    }
    
    #[Route('/facture/creation', name: "facture.new", methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture, ['route' => 'facture.new']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $facture = $form->getData();

            $manager->persist($facture);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre facture a été crée avec succès !'
            );

            return $this->redirectToRoute('app_facture');
        }

        return $this->render('facture/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[route('/facture/edition/{id}', name: 'facture.edit', methods: ['GET', 'POST',])]
    public function edit(Facture $facture, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(factureType::class, $facture, ['route' => 'facture.edit']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $facture = $form->getData();
            $manager->persist($facture);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre facture a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_facture');
        }

        return $this->render('facture/modif.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/facture/suppression/{id}', name: 'facture.delete', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $manager, Facture $facture): Response
    {
        $manager->remove($facture);
        $manager->flush();

        $this->addFlash(
            'success',
            'la facture a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_facture');
    }
}
