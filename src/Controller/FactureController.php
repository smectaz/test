<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Services\appelFacture;
use App\Repository\FactureRepository;
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
    public function edition(appelFacture $appel, FactureRepository $repository, PaginatorInterface $paginator, Request $request, Facture $facture): Response
    {
        $factures = $appel->edition($repository, $paginator, $request);
    


        return $this->render('facture/index.html.twig', [
            'factures' => $factures,

        ]);
    }
}
