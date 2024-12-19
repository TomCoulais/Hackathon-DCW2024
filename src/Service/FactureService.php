<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FactureRepository;
use App\Entity\Facture;

class FactureService
{
    private EntityManagerInterface $em;
    private FactureRepository $factureRepository;

    public function __construct(EntityManagerInterface $em, FactureRepository $factureRepository)
    {
        $this->em = $em;
        $this->factureRepository = $factureRepository;
    }

    public function getPaginatedFactures(string $search = '', int $page = 1, int $limit = 10): array
    {
        $factureQueryBuilder = $this->applySearchConditions($search);
        $this->applyPagination($factureQueryBuilder, $page, $limit);

        $factures = $factureQueryBuilder->getQuery()->getResult();
        $totalFactures = $this->getTotalFacturesCount($search);

        $totalPages = ceil($totalFactures / $limit);
        return [
            'factures' => $factures,
            'totalPages' => $totalPages,
        ];
    }

    private function applySearchConditions(string $search): \Doctrine\ORM\QueryBuilder
    {
        $factureQueryBuilder = $this->factureRepository->createQueryBuilder('f')
            ->leftJoin('f.client', 'c'); 

        if ($search) {
            $factureQueryBuilder
                ->where('c.name LIKE :search') 
                ->orWhere('f.statut LIKE :search') 
                ->setParameter('search', '%' . $search . '%');
        }

        return $factureQueryBuilder;
    }

    private function applyPagination($factureQueryBuilder, int $page, int $limit): void
    {
        $factureQueryBuilder
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);
    }

    private function getTotalFacturesCount(string $search): int
    {
        $factureQueryBuilder = $this->applySearchConditions($search);

        return (int) $factureQueryBuilder->select('count(f.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
