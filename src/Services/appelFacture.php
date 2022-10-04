<?php

namespace App\Services;

use App\Repository\FactureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;


class appelFacture
{
    public function edition(FactureRepository $repository, PaginatorInterface $paginator, Request $request)
    {
        $factures = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $factures;
    }
}
