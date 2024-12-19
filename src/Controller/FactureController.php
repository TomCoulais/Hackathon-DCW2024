<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureAddType;
use App\Form\FactureEditType;
use App\Repository\FactureRepository;
use App\Service\FactureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    #[Route('/factures', name: 'app_factures', methods: ['GET'])]
    public function index(Request $request, FactureService $factureService): Response
    {
        $search = $request->query->get('search', ''); 
        $page = max(1, $request->query->getInt('page', 1)); 
        $limit = 10; 

        $result = $factureService->getPaginatedFactures($search, $page, $limit);

        return $this->render('facture/index.html.twig', [
            'factures' => $result['factures'], 
            'search' => $search, 
            'currentPage' => $page, 
            'totalPages' => $result['totalPages'], 
        ]);
    }
    

    #[Route('/factures/new', name: 'app_facture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureAddType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('app_factures', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/factures/edit/{id}', name: 'app_facture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureEditType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_factures', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_facture_delete', methods: ['POST'])]
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $facture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_factures', [], Response::HTTP_SEE_OTHER);
    }
}