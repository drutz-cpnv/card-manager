<?php

namespace App\Command;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Repository\RankRepository;
use App\Repository\RoleRepository;
use App\Service\VirtualCardService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test',
    description: 'Add a short description for your command',
)]
class TestCommand extends Command
{
    public function __construct(
        private VirtualCardService $virtualCardService,
        private RoleRepository $roleRepository,
        private RankRepository $rankRepository,
        private EntityManagerInterface $entityManager,
        string $name = null
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
