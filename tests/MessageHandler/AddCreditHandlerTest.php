<?php

namespace App\Tests\MessageHandler;

use App\Entity\Wallet;
use App\Message\Command\AddCredit;
use App\MessageHandler\AddCreditHandler;
use App\Repository\WalletRepository;
use PHPUnit\Framework\TestCase;

class AddCreditHandlerTest extends TestCase
{
    public function testCreditIsAddedToWallet(): void
    {
        // 1. Préparation (Arrange)
        // On crée une fausse commande : User 123 veut ajouter 50€
        $command = new AddCredit(123, 50);

        // On crée un faux Wallet qui a déjà 100€
        $wallet = new Wallet();
        $wallet->setUserId(123);
        $wallet->setBalance(100);

        // On Mock le Repository (On fait semblant qu'il existe)
        $walletRepo = $this->createMock(WalletRepository::class);

        // On dit au Mock : "Quand on cherche le user 123, retourne mon faux wallet"
        $walletRepo->expects($this->once())
            ->method('findOneBy')
            ->with(['userId' => 123])
            ->willReturn($wallet);

        // On s'attend à ce que la méthode save() soit appelée une fois à la fin
        $walletRepo->expects($this->once())
            ->method('save')
            ->with($wallet); // On vérifie qu'on sauvegarde bien ce wallet

        // 2. Action (Act)
        // On instancie le Handler avec le faux repo
        $handler = new AddCreditHandler($walletRepo);
        // On lance le handler
        $handler($command);

        // 3. Vérification (Assert)
        // Le solde devrait être 100 (initial) + 50 (ajout) = 150
        $this->assertEquals(150, $wallet->getBalance());
    }
}
