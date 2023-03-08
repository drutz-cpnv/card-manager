<?php

namespace App\Command;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:default:role',
    description: 'Add a short description for your command',
)]
class DefaultRoleCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager, private RoleRepository $roleRepository, string $name = null)
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

        $io->success(["Opération términée avec succès", "$count fonctions ajoutée(s)"]);

        return Command::SUCCESS;
    }

    private function createEntities()
    {
        $current_roles = $this->roleRepository->findAll();
        $current_roles = array_map(function (Role $role) {
            return $role->getName();
        }, $current_roles);

        $roles = [];

        $roles[] = (new Role())
            ->setName("Commandant•e")
            ->setValue([
                "Commandant•e",
                "Commandante",
                "Commandant",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Assistant•e de direction")
            ->setValue([
                "Assistant•e de direction",
                "Assistante de direction",
                "Assistant de direction",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Responsable RH")
            ->setValue([
                "Responsable RH",
                "Responsable RH",
                "Responsable RH",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Chef•fe opérationnel")
            ->setValue([
                "Chef•fe opérationnel",
                "Cheffe opérationnel",
                "Chef opérationnel",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Chef•fe police de proximité et d'intervention")
            ->setValue([
                "Chef•fe police de proximité et d'intervention",
                "Cheffe police de proximité et d'intervention",
                "Chef police de proximité et d'intervention",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Chef•fe de brigade")
            ->setValue([
                "Chef•fe de brigade",
                "Cheffe de brigade",
                "Chef de brigade",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Chef•fe de brigade remplaçant•e")
            ->setValue([
                "Chef•fe de brigade remplaçant•e",
                "Cheffe de brigade remplaçante",
                "Chef de brigade remplaçant",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Polici•er•ère")
            ->setValue([
                "Polici•er•ère",
                "Policière",
                "Policier",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Centraliste")
            ->setValue([
                "Centraliste",
                "Centraliste",
                "Centraliste",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Réceptionniste")
            ->setValue([
                "Réceptionniste",
                "Réceptionniste",
                "Réceptionniste",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Aspirant•e")
            ->setValue([
                "Aspirant•e",
                "Aspirante",
                "Aspirant",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Responsable des systèmes d'information")
            ->setValue([
                "Responsable des systèmes d'information",
                "Responsable des systèmes d'information",
                "Responsable des systèmes d'information",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Responsable de l'intendance")
            ->setValue([
                "Responsable de l'intendance",
                "Responsable de l'intendance",
                "Responsable de l'intendance",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Responsable d'exploitation")
            ->setValue([
                "Responsable d'exploitation",
                "Responsable d'exploitation",
                "Responsable d'exploitation",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Responsable du Secrétariat")
            ->setValue([
                "Responsable du Secrétariat",
                "Responsable du Secrétariat",
                "Responsable du Secrétariat",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Collaborat•eur•rice")
            ->setValue([
                "Collaborat•eur•rice",
                "Collaboratrice",
                "Collaborateur",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Apprenti•e")
            ->setValue([
                "Apprenti•e",
                "Apprentie",
                "Apprenti",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Chef•fe sécurité publique")
            ->setValue([
                "Chef•fe sécurité publique",
                "Cheffe sécurité publique",
                "Chef sécurité publique",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Chef•fe d'unité")
            ->setValue([
                "Chef•fe d'unité",
                "Cheffe d'unité",
                "Chef d'unité",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Opérat•eur•rice radar")
            ->setValue([
                "Opérat•eur•rice radar",
                "Opératrice radar",
                "Opérateur radar",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Président•e de la Commission de Police")
            ->setValue([
                "Président•e de la Commission de Police",
                "Présidente de la Commission de Police",
                "Président de la Commission de Police",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Responsable police du commerce")
            ->setValue([
                "Responsable police du commerce",
                "Responsable police du commerce",
                "Responsable police du commerce",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Inspect•eur•rice police du commerce")
            ->setValue([
                "Inspect•eur•rice police du commerce",
                "Inspectrice police du commerce",
                "Inspecteur police du commerce",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Responsable de la Signalisation")
            ->setValue([
                "Responsable de la Signalisation",
                "Responsable de la Signalisation",
                "Responsable de la Signalisation",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Ouvri•er•ère spécialisé•e")
            ->setValue([
                "Ouvri•er•ère spécialisé•e",
                "Ouvrière spécialisée",
                "Ouvrier spécialisé",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Président•e du CODIR")
            ->setValue([
                "Président•e du CODIR",
                "Présidente du CODIR",
                "Président du CODIR",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Vice-président•e du CODIR")
            ->setValue([
                "Vice-président•e du CODIR",
                "Vice-présidente du CODIR",
                "Vice-président du CODIR",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Municipal•e de Morges")
            ->setValue([
                "Municipal•e de Morges",
                "Municipale de Morges",
                "Municipal de Morges",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Municipal•e de Saint-Prex")
            ->setValue([
                "Municipal•e de Saint-Prex",
                "Municipale de Saint-Prex",
                "Municipal de Saint-Prex",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Municipal•e de Buchillon")
            ->setValue([
                "Municipal•e de Buchillon",
                "Municipale de Buchillon",
                "Municipal de Buchillon",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Municipal•e de Préverenges")
            ->setValue([
                "Municipal•e de Préverenges",
                "Municipale de Préverenges",
                "Municipal de Préverenges",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Municipal•e de Lussy-sur-Morges")
            ->setValue([
                "Municipal•e de Lussy-sur-Morges",
                "Municipale de Lussy-sur-Morges",
                "Municipal de Lussy-sur-Morges",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Municipal•e de Tolochenaz")
            ->setValue([
                "Municipal•e de Tolochenaz",
                "Municipale de Tolochenaz",
                "Municipal de Tolochenaz",
            ])
        ;

        $roles[] = (new Role())
            ->setName("Chef•fe de service")
            ->setValue([
                "Chef•fe de service",
                "Cheffe de service",
                "Chef de service",
            ])
        ;


        $count = 0;

        foreach ($roles as $role) {
            if(!in_array($role->getName(), $current_roles)) {
                $this->entityManager->persist($role);
                $count++;
            }
        }

        $this->entityManager->flush();

        return $count;

    }
}
