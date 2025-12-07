<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WalletControllerTest extends WebTestCase
{
    public function testAddCreditEndpoint(): void
    {
        // 1. On crée un client HTTP simulé
        $client = static::createClient();

        // 2. On envoie une requête POST avec du JSON
        $client->request(
            'POST',
            '/api/credit',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'userId' => 123,
                'amount' => 500
            ])
        );

        // 3. On vérifie que le code de retour est bien 202 Accepted
        $this->assertResponseStatusCodeSame(202);

        // 4. On vérifie que la réponse est bien un JSON valide
        $responseContent = $client->getResponse()->getContent();
        $this->assertJson($responseContent);

        // Optionnel : vérifier le contenu précis
        $this->assertStringContainsString('accepted', $responseContent);
    }
}
