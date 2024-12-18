<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Facture;
use App\Form\ClientAddType;
use App\Form\ClientEditType;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/clients')]
final class ClientController extends AbstractController
{
    #[Route(name: 'app_clients', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $clients = $em->getRepository(Client::class)->findAll();

        foreach ($clients as $client) {
            $totalMontant = 0;
    
            $factures = $em->getRepository(Facture::class)->findBy(['client' => $client]);
            
            foreach ($factures as $facture) {
                $totalMontant += $facture->getMontant();  
            }
            $client->totalMontant = $totalMontant;
        }
    
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }
    

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
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

    #[Route('/edit/{id}', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientEditType::class, $client);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_clients', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/client/deleted/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, EntityManagerInterface $em): Response
    {
        $em->remove($client);
        $em->flush();
    
        return $this->redirectToRoute('app_clients', [], Response::HTTP_SEE_OTHER);
    }
    
}