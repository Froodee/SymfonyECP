<?php

namespace App\Command;

use App\Entity\Admin;
use App\Entity\User;
use App\Entity\Utilisateurs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:create-users', description: 'Crée un utilisateur validé et un admin de test')]
class CreateUsersCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // --- Utilisateur validé ---
        $utilisateur1 = new Utilisateurs();
        $utilisateur1->setIdUser(10);
        $utilisateur1->setNomUser('Jean Dupont');
        $utilisateur1->setAdrUser('10 rue de la Paix');
        $utilisateur1->setCpUser('75001');
        $utilisateur1->setVilleUser('Paris');
        $utilisateur1->setNumUser('0600000001');
        $utilisateur1->setEmailUser('user.valide@test.com');
        $this->em->persist($utilisateur1);

        $user1 = new User();
        $user1->setEmail('user.valide@test.com');
        $user1->setPassword($this->hasher->hashPassword($user1, 'User1234!'));
        $user1->setIsVerified(true);
        $user1->setEstValide(true);
        $user1->setUtilisateur($utilisateur1);
        $this->em->persist($user1);

        // --- Admin ---
        $utilisateur2 = new Utilisateurs();
        $utilisateur2->setIdUser(99);
        $utilisateur2->setNomUser('Admin ECP');
        $utilisateur2->setAdrUser('1 rue Admin');
        $utilisateur2->setCpUser('75001');
        $utilisateur2->setVilleUser('Paris');
        $utilisateur2->setNumUser('0100000000');
        $utilisateur2->setEmailUser('admin@ecp.com');
        $this->em->persist($utilisateur2);

        $user2 = new User();
        $user2->setEmail('admin@ecp.com');
        $user2->setPassword($this->hasher->hashPassword($user2, 'Admin1234!'));
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setIsVerified(true);
        $user2->setEstValide(true);
        $user2->setUtilisateur($utilisateur2);
        $this->em->persist($user2);

        $admin = new Admin();
        $admin->setIdUser($utilisateur2);
        $this->em->persist($admin);

        $this->em->flush();

        $io->success('Utilisateurs créés avec succès !');
        $io->table(
            ['Email', 'Mot de passe', 'Rôle'],
            [
                ['user.valide@test.com', 'User1234!', 'ROLE_USER + validé'],
                ['admin@ecp.com',        'Admin1234!', 'ROLE_ADMIN'],
            ]
        );

        return Command::SUCCESS;
    }
}
