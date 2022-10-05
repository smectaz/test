<?php

namespace App\Services;

class appelFacture
{
    public function findAll($repository, $paginator, $request)
    {
        $appel = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $appel;
    }

    public function delete($manager, $objet)
    {
        $manager->remove($objet);
        $manager->flush();
    }
}
