<?php

namespace App\Controller;

use App\Message\Command\AddCredit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class WalletController extends AbstractController
{
    #[Route('/api/credit', methods: ['POST'])]
    public function addCredit(Request $request, MessageBusInterface $bus): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation basique (optionnel mais recommandé)
        if (!isset($data['userId'], $data['amount'])) {
            return new JsonResponse(['error' => 'Missing parameters'], 400);
        }

        // On crée la commande (Intention)
        $command = new AddCredit($data['userId'], (int) $data['amount']);

        // On la dispatch. Le contrôleur ne sait pas CE QUI va se passer ensuite.
        $bus->dispatch($command);

        return new JsonResponse(['status' => 'accepted'], 202);
    }
}
