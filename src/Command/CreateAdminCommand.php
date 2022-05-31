<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin-command';

    private UserPasswordHasherInterface $encoder;

    private EntityManagerInterface $manager;

    /**
     * ImportCommand constructor.
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        UserPasswordHasherInterface $encoder,
        EntityManagerInterface $manager
    ) {
        parent::__construct(self::$defaultName);
        $this->encoder = $encoder;
        $this->manager = $manager;
    }

    protected function configure()
    {
        $this->setDescription('Inscription user admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = (new User())
            ->setFirstname("God")
            ->setLastname("Spirit")
            ->setEmail("essonoadou@gmail.com")
            ->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->encoder->hashPassword($user, "espirito237"));
        $this->manager->persist($user);

        $this->manager->flush();
        $io->success('Inscription useradmin réussie');
        return Command::SUCCESS;
    }
}
