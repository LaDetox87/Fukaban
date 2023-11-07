<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Projets;
use App\Entity\Taches;
use App\Entity\Statut;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $Statut = new Statut();
            if ($i%3 == 0){
                $Statut->setLibelle('à faire');
            }else if ($i%3 == 1){
                $Statut->setLibelle('en cours');
            }else{
                $Statut->setLibelle('terminée');
            }
            $manager->persist($Statut);
        }
        for ($i = 0; $i < 5; $i++) {

            $Projet = new Projets();
            $Projet->setNom('Projet'.$i+1);
            $Projet->setDescription('Description du Projet'.$i+1);
            if ($i<10){
                $Projet->setDateCreation('2023-11-0'.$i);
                $Projet->setDateModification('2023-11-0'.$i);
            }else{
                $Projet->setDateCreation('2023-11-'.$i);
                $Projet->setDateModification('2023-11-'.$i);
            }
            $manager->persist($Projet);
        }
        for ($i = 0; $i < 20; $i++) {

            $Taches = new Taches();
            $Taches->setIdStatutId($i%3);
            $Taches->setIdProjetId($i%5);
            $Taches->setIdUserId(1);
            $Taches->setTitre("Tache numéro ".$i);
            $Taches->setDescription("Voici la tache numéro ".$i);
            if ($i<10){
                $Projet->setDateCreation('2023-11-0'.$i);
                
            }else{
                $Projet->setDateCreation('2023-11-'.$i);
                
            }
            if ($i+7<10){
                $Projet->setDateFin('2023-11-0'.$i+7);
            }else{
                $Projet->setDateFin('2023-11-'.$i+7);
            }

            $manager->persist($Taches);
        }

        $manager->flush();
    }
}
