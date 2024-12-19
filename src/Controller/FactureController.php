<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureAddType;
use App\Form\FactureEditType;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    #[Route('/factures', name: 'app_factures', methods: ['GET'])]
    public function index(Request $request, FactureRepository $factureRepository): Response
    {
        $search = $request->query->get('search', '');
    
        $facturesQueryBuilder = $factureRepository->createQueryBuilder('f')
            ->leftJoin('f.client', 'c')
            ->where('c.name LIKE :search')
            ->orWhere('f.statut LIKE :search')
            ->setParameter('search', '%' . $search . '%'); 
    
        $factures = $facturesQueryBuilder->getQuery()->getResult();
    
        return $this->render('facture/index.html.twig', [
            'factures' => $factures,
            'search' => $search,
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