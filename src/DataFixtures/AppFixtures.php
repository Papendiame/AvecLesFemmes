<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Groupement;
use App\Entity\Membre;
use App\Entity\ModeCotisation;
use App\Entity\Role;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Rôles : Admin / Membre simple
        $roleAdmin = (new Role())->setNomRole('Admin');
        $roleMembre = (new Role())->setNomRole('Membre simple');
        $manager->persist($roleAdmin);
        $manager->persist($roleMembre);

        // Types de campagne : Tontine / Épargne
        $tontine = (new Type())->setNomType('Tontine');
        $epargne = (new Type())->setNomType('Épargne');
        $manager->persist($tontine);
        $manager->persist($epargne);

        // Groupements et leurs membres : [nomComplet, login, fonction, téléphone]
        $groupementsData = [
            [
                'nom' => 'Groupement Les Étoiles',
                'adresse' => 'Médina, Dakar',
                'tel' => '771000001',
                'membres' => [
                    ['Awa Diop', 'admin', 'Présidente', '771000011'],
                    ['Fatou Ndiaye', 'fatou', 'Adjointe', '771000012'],
                    ['Khady Sow', 'khady', 'Trésorière', '771000013'],
                ],
            ],
            [
                'nom' => 'Groupement Teranga',
                'adresse' => 'Pikine, Dakar',
                'tel' => '771000002',
                'membres' => [
                    ['Mame Fall', 'mame', 'Présidente', '771000021'],
                    ['Aminata Ba', 'aminata', 'Adjointe', '771000022'],
                    ['Ndeye Sarr', 'ndeye', 'Trésorière', '771000023'],
                ],
            ],
        ];

        foreach ($groupementsData as $data) {
            $groupement = (new Groupement())
                ->setNom($data['nom'])
                ->setAdresse($data['adresse'])
                ->setTelephone($data['tel']);
            $manager->persist($groupement);

            $membres = [];
            foreach ($data['membres'] as [$nomComplet, $login, $fonction, $tel]) {
                $estAdmin = $login === 'admin';

                $membre = new Membre();
                $membre->setNomComplet($nomComplet)
                    ->setTelephone($tel)
                    ->setAdresse($data['adresse'])
                    ->setLogin($login)
                    ->setFonction($fonction)
                    ->setRole($estAdmin ? $roleAdmin : $roleMembre)
                    ->setGroupement($groupement);
                $membre->setPassword(
                    $this->hasher->hashPassword($membre, $estAdmin ? 'admin123' : 'membre123')
                );
                $manager->persist($membre);
                $membres[] = $membre;
            }

            // Campagnes du groupement : [campagne, libre]
            $campagnes = [
                [(new Campagne())
                    ->setNom('Tontine mensuelle - ' . $data['nom'])
                    ->setDateDebut(new \DateTimeImmutable('2026-11-01'))
                    ->setDateFin(new \DateTimeImmutable('2027-04-30'))
                    ->setMontant('10000.00')
                    ->setType($tontine)
                    ->setGroupement($groupement), false],
                [(new Campagne())
                    ->setNom('Épargne solidaire - ' . $data['nom'])
                    ->setDateDebut(new \DateTimeImmutable('2026-11-01'))
                    ->setDateFin(new \DateTimeImmutable('2027-10-31'))
                    ->setMontant('5000.00')
                    ->setType($epargne)
                    ->setGroupement($groupement), true],
            ];

            foreach ($campagnes as [$campagne, $libre]) {
                $manager->persist($campagne);

                foreach ($membres as $membre) {
                    $mode = (new ModeCotisation())
                        ->setLibre($libre)
                        ->setCampagne($campagne)
                        ->setMembre($membre);
                    $manager->persist($mode);
                }
            }
        }

        $manager->flush();
    }
}