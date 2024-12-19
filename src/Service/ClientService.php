<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Entity\Client; 
use App\Entity\Facture;

class ClientService
{
    private EntityManagerInterface $em;
    private ClientRepository $clientRepository;
    private FactureRepository $factureRepository;
    public function __construct(EntityManagerInterface $em, ClientRepository $clientRepository, FactureRepository $factureRepository)
    {
        $this->em = $em;
        $this->clientRepository = $clientRepository;
        $this->factureRepository = $factureRepository;
    }

    public function getPaginatedClients(string $search = '', int $page = 1, int $limit = 10): array
    {
        $clientQueryBuilder = $this->applySearchConditions($search);
    
        $this->applyPagination($clientQueryBuilder, $page, $limit);
    
        $clients = $clientQueryBuilder->getQuery()->getResult();
        $totalClients = $this->getTotalClientsCount($search);
    
        $totalPages = ceil($totalClients / $limit);
        foreach ($clients as $client) {
            $totalMontant = 0;
            $factures = $this->em->getRepository(Facture::class)->findBy(['client' => $client]);
    
            foreach ($factures as $facture) {
                $totalMontant += $facture->getMontant();
            }
            $client->totalMontant = $totalMontant;
        }
    
        return [
            'clients' => $clients,
            'totalPages' => $totalPages,
        ];
    }
    
    private function applySearchConditions(string $search): \Doctrine\ORM\QueryBuilder
    {
        $clientQueryBuilder = $this->em->getRepository(Client::class)->createQueryBuilder('c');
    
        if ($search) {
            if (is_numeric($search)) {
                $clientQueryBuilder
                    ->where('c.id = :search')
                    ->setParameter('search', (int) $search);
            } else {
                $clientQueryBuilder
                    ->where('c.name LIKE :search')
                    ->orWhere('c.email LIKE :search')
                    ->setParameter('search', '%' . $search . '%');
            }
        }
    
        return $clientQueryBuilder;
    }
    
    private function applyPagination($clientQueryBuilder, int $page, int $limit): void
    {
        $clientQueryBuilder
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);
    }
    
    private function getTotalClientsCount(string $search): int
    {
        $totalClientsQueryBuilder = $this->applySearchConditions($search);
    
        return (int) $totalClientsQueryBuilder->select('count(c.id)')
                                              ->getQuery()
                                              ->getSingleScalarResult();
    }
    
    
}
