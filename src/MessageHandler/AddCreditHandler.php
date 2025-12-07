<?php

namespace App\MessageHandler;

use App\Message\Command\AddCredit;
use App\Repository\WalletRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
// ... imports Doctrine, Repository, Entity ...

#[AsMessageHandler]
class AddCreditHandler
{
    public function __construct(private WalletRepository $walletRepo) {}

    public function __invoke(AddCredit $command): void
    {
        // 1. Récupérer le wallet
        $wallet = $this->walletRepo->findOneBy(['userId' => $command->userId]);

        // 2. Logique métier
        $wallet->setBalance($wallet->getBalance() + $command->amount);

        // 3. Sauvegarde
        $this->walletRepo->save($wallet);

        // Note: En CQRS pur, on ne retourne rien ici, ou juste un ID.
    }
}
