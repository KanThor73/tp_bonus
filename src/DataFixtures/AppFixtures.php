<?php

namespace App\DataFixtures;

use App\Entity\SousCategories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $souscategories = [
            1 => [
                'libelle' => 'Vtt',
            ],
            2 => [
                'libelle' => 'Velo de route'
            ],
            3 => [
                'libelle' => 'Velo de ville'
            ],
            4 => [
                'libelle' => 'Montagne'
            ],
            5 => [
                'libelle' => 'Ville'
            ],
            6 => [
                'libelle' => 'Travail'
            ],
            7 => [
                'libelle' => 'Course'
            ]
        ];

        foreach ($souscategories as $key => $value) {
            $souscategorie = new SousCategories();
            $souscategorie->setLibelle($value['libelle']);
            $manager->persist($souscategorie);
        }

        $manager->flush();
    }
}
