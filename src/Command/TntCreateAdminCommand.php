<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'tnt:create-admin',
    description: 'Add a short description for your command',
)]
class TntCreateAdminCommand extends Command
{
    private $entityManager;
    private $passwordHasher;
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Crée un nouvel utilisateur administrateur.')
            ->setHelp('Cette commande permet de créer un utilisateur...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $questionUsername = new Question('Entrez l\' username de l\'administrateur : ');
        $userName = $helper->ask($input, $output, $questionUsername);

        $questionPassword = new Question('Entrez le mot de passe de l\'administrateur : ');
        $password = $helper->ask($input, $output, $questionPassword);

        $user = new User();
        $user->setUsername($userName);
        $user->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Utilisateur administrateur créé avec succès !');

        return Command::SUCCESS;
    }
}
