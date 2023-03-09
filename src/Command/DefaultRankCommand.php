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
        $in_ranks = [];
        foreach ($current_ranks as $current_rank) {
            $in_ranks[$current_rank->getName()] = $current_rank;
        }

        $ranks = [];
        $to_persist = [];

        $ranks[] = (new Rank())
            ->setName("Madame/Monsieur")
            ->setValue([
                "Madame/Monsieur",
                "Madame",
                "Monsieur"
            ])
            ->setAbbreviation([
                0 => "M./Mme.",
                1 => "Mme.",
                2 => "M."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Lieutenant-Colonel")
            ->setValue([
                "Lieutenant-Colonel",
                "Lieutenant-Colonel",
                "Lieutenant-Colonel"
            ])
            ->setAbbreviation([
                0 => "Lt col.",
                1 => "Lt col",
                2 => "Lt col"
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Capitaine")
            ->setValue([
                "Capitaine",
                "Capitaine",
                "Capitaine"
            ])
            ->setAbbreviation([
                0 => "Cap.",
                1 => "Cap.",
                2 => "Cap."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Premier-Lieutenant")
            ->setValue([
                "Premi•er•ère-Lieutenant",
                "Première-Lieutenant",
                "Premier-Lieutenant"
            ])
            ->setAbbreviation([
                0 => "Plt.",
                1 => "Plt.",
                2 => "Plt."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Adjudant")
            ->setValue([
                "Adjudant",
                "Adjudant",
                "Adjudant"
            ])
            ->setAbbreviation([
                0 => "Adj.",
                1 => "Adj.",
                2 => "Adj."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Sergent-Major•e")
            ->setValue([
                "Sergent-Major•e",
                "Sergent-Majore",
                "Sergent-Major"
            ])
            ->setAbbreviation([
                0 => "Sgtm•e.",
                1 => "Sgtme.",
                2 => "Sgtm."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Sergent")
            ->setValue([
                "Sergent",
                "Sergent",
                "Sergent"
            ])
            ->setAbbreviation([
                0 => "Sgt.",
                1 => "Sgt.",
                2 => "Sgt."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Caporal•e")
            ->setValue([
                "Caporal•e",
                "Caporale",
                "Caporal"
            ])
            ->setAbbreviation([
                0 => "Cpl•e.",
                1 => "Cple.",
                2 => "Cpl."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Appointé•e")
            ->setValue([
                "Appointé•e",
                "Appointée",
                "Appointé"
            ])
            ->setAbbreviation([
                0 => "App•e.",
                1 => "Appe.",
                2 => "App."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Agent•e")
            ->setValue([
                "Agent•e",
                "Agente",
                "Agent"
            ])
            ->setAbbreviation([
                0 => "Agt•e.",
                1 => "Agte.",
                2 => "Agt."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Chef•fe")
            ->setValue([
                "Chef•fe",
                "Cheffe",
                "Chef"
            ])
            ->setAbbreviation([
                0 => "Mme./M.",
                1 => "Mme.",
                2 => "M."
            ])
        ;

        $ranks[] = (new Rank())
            ->setName("Aspirant•e")
            ->setValue([
                "Aspirant•e",
                "Aspirante",
                "Aspirant"
            ])
            ->setAbbreviation([
                0 => "Asp•e.",
                1 => "Aspe.",
                2 => "Asp."
            ])
        ;

        $count = 0;

        foreach ($ranks as $rank) {
            if(!array_key_exists($rank->getName(), $in_ranks)) {
                $this->entityManager->persist($rank);
                $count++;
            } else {
                $update = $in_ranks[$rank->getName()];
                $update
                    ->setName($rank->getName())
                    ->setAbbreviation($rank->getAbbreviation())
                    ->setValue($rank->getValue())
                ;
            }
        }

        $this->entityManager->flush();

        return $count;

    }
}
