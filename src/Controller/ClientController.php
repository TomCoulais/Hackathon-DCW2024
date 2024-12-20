<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Facture;
use App\Form\ClientAddType;
use App\Form\ClientEditType;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Service\ClientService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
#[Route('/clients', name: 'app_clients', methods: ['GET'])]
public function index(Request $request, ClientService $clientService): Response
{
    $search = $request->query->get('search', '');
    $page = max(1, $request->query->getInt('page', 1));
    $limit = 10;
    
    $sortOrder = $request->query->get('sort', 'desc'); 

    $result = $clientService->getPaginatedClients($search, $page, $limit, $sortOrder);
    
    return $this->render('client/index.html.twig', [
        'clientsSearch' => $result['clients'],
        'search' => $search,
        'currentPage' => $page,
        'totalPages' => $result['totalPages'],
        'sortOrder' => $sortOrder, 
    ]);
}

    
    
    

    #[Route('/clients/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientAddType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('app_clients', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }
    

    #[Route('/clients/deleted/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, EntityManagerInterface $em): Response
    {
        $em->remove($client);
        $em->flush();
    
        return $this->redirectToRoute('app_clients', [], Response::HTTP_SEE_OTHER);
    }
    
}