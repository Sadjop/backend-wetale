<?php

namespace App\Controller;

use App\Entity\SubscriptionType;
use App\Form\SubscriptionTypeType;
use App\Repository\SubscriptionTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subscription/type')]
final class SubscriptionTypeController extends AbstractController
{
    #[Route(name: 'app_subscription_type_index', methods: ['GET'])]
    public function index(SubscriptionTypeRepository $subscriptionTypeRepository): Response
    {
        return $this->render('subscription_type/index.html.twig', [
            'subscription_types' => $subscriptionTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_subscription_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $subscriptionType = new SubscriptionType();
        $form = $this->createForm(SubscriptionTypeType::class, $subscriptionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($subscriptionType);
            $entityManager->flush();

            return $this->redirectToRoute('app_subscription_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subscription_type/new.html.twig', [
            'subscription_type' => $subscriptionType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subscription_type_show', methods: ['GET'])]
    public function show(SubscriptionType $subscriptionType): Response
    {
        return $this->render('subscription_type/show.html.twig', [
            'subscription_type' => $subscriptionType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_subscription_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubscriptionType $subscriptionType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubscriptionTypeType::class, $subscriptionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_subscription_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subscription_type/edit.html.twig', [
            'subscription_type' => $subscriptionType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subscription_type_delete', methods: ['POST'])]
    public function delete(Request $request, SubscriptionType $subscriptionType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscriptionType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($subscriptionType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_subscription_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
