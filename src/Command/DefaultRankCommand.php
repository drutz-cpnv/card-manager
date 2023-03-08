<?php

namespace App\Command;

use App\Entity\Rank;
use App\Repository\RankRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:default:rank',
    description: 'Add a short description for your command',
)]
class DefaultRankCommand extends Command
{

    public function __construct(private EntityManagerInterface $entityManager, private RankRepository $rankRepository, string $name = null, )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info("Création et ajout à la base de données des nouvelles entités.");

        $count = $this->createEntities();

        $io->success(["Opération términée avec succès", "$count titre/grade(s) ajouté(s)"]);

        return Command::SUCCESS;
    }

    private function createEntities()
    {

        $current_ranks = $this->rankRepository->findAll();
        $current_ranks = array_map(function (Rank $rank) {
            return $rank->getName();
        }, $current_ranks);

        $ranks = [];
        $to_persist = [];

        $ranks[] = (new Rank())
            ->setName("Madame/Monsieur")
            ->setValue([
                "Madame/Monsieur",
                "Madame",
                "Monsieur"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Lieutenant-Colonel")
            ->setValue([
                "Lieutenant-Colonel",
                "Lieutenant-Colonel",
                "Lieutenant-Colonel"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Capitaine")
            ->setValue([
                "Capitaine",
                "Capitaine",
                "Capitaine"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Premier-Lieutenant")
            ->setValue([
                "Premi•er•ère-Lieutenant",
                "Première-Lieutenant",
                "Premier-Lieutenant"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Adjudant")
            ->setValue([
                "Adjudant",
                "Adjudant",
                "Adjudant"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Sergent-Major•e")
            ->setValue([
                "Sergent-Major•e",
                "Sergent-Majore",
                "Sergent-Major"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Sergent")
            ->setValue([
                "Sergent",
                "Sergent",
                "Sergent"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Caporal•e")
            ->setValue([
                "Caporal•e",
                "Caporale",
                "Caporal"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Appointé•e")
            ->setValue([
                "Appointé•e",
                "Appointée",
                "Appointé"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Agent•e")
            ->setValue([
                "Agent•e",
                "Agente",
                "Agent"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Chef•fe")
            ->setValue([
                "Chef•fe",
                "Cheffe",
                "Chef"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Aspirant•e")
            ->setValue([
                "Aspirant•e",
                "Aspirante",
                "Aspirant"
            ])
        ;

        $count = 0;

        foreach ($ranks as $rank) {
            if(!in_array($rank->getName(), $current_ranks)) {
                $this->entityManager->persist($rank);
                $count++;
            }
        }

        $this->entityManager->flush();

        return $count;

    }
}
