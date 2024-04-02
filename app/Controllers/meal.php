<?php

namespace App\Controllers;

use App\Models\FoodModel;
use App\Models\MealModel;

class Meal extends BaseController
{
    public function MealGeneration(): string
    {
        // Instancier les modèles
        $foodModel = new FoodModel();
        $mealModel = new MealModel();

        // Récupérer les aliments de type "céréale" pour le petit déjeuner
        $cereals = $foodModel->where('type', 'Céréale')->findAll();

        // Récupérer les fruits pour le petit déjeuner
        $fruits = $foodModel->where('type', 'Fruit')->findAll();

        // Récupérer les boissons pour le petit déjeuner
        $boissons = $foodModel->where('type', 'Boisson')->findAll();

        // Récupérer les aliments de type "protéine" pour le déjeuner
        $proteines = $foodModel->where('type', 'Protéine')->findAll();

        // Récupérer les aliments de type "féculent" pour le déjeuner
        $feculents = $foodModel->where('type', 'Féculent')->findAll();

        // Récupérer les aliments de type "légume" pour le déjeuner
        $legumes = $foodModel->where('type', 'Légume')->findAll();

        // Logique de génération de menus pour le petit déjeuner
        $petitDejMenus = [];
        foreach ($cereals as $cereal) {
            foreach ($fruits as $fruit) {
                foreach ($boissons as $boisson) {
                    $petitDejMenus[] = [
                        'cereal' => $cereal,
                        'fruit' => $fruit,
                        'boisson' => $boisson
                    ];
                }
            }
        }

        // Logique de génération de menus pour le déjeuner
        $dejeunerMenus = [];
        foreach ($proteines as $proteine) {
            foreach ($feculents as $feculent) {
                foreach ($legumes as $legume) {
                    $dejeunerMenus[] = [
                        'proteine' => $proteine,
                        'feculent' => $feculent,
                        'legume' => $legume
                    ];
                }
            }
        }

         // Logique de génération de menus pour le petit déjeuner
         $petitDejMenus = [];
         foreach ($cereals as $cereal) {
             foreach ($fruits as $fruit) {
                 foreach ($boissons as $boisson) {
                     // Insérer le menu dans la base de données
                     $mealModel->insert([
                         'id_proteinFood' => null,
                         'id_starchyFood' => $cereal['id_food'],
                         'id_vegetableFood' => null,
                         'mealType' => 'Petit déjeuner',
                         'proteinPortion' => null,
                         'starchyPortion' => $cereal['id_food'], // Utiliser l'ID de la céréale
                         'vegetablePortion' => null
                     ]);
                 }
             }
         }
 
         // Logique de génération de menus pour le déjeuner
         $dejeunerMenus = [];
         foreach ($proteines as $proteine) {
             foreach ($feculents as $feculent) {
                 foreach ($legumes as $legume) {
                     // Insérer le menu dans la base de données
                     $mealModel->insert([
                         'id_proteinFood' => $proteine['id_food'],
                         'id_starchyFood' => $feculent['id_food'],
                         'id_vegetableFood' => $legume['id_food'],
                         'mealType' => 'Déjeuner',
                         'proteinPortion' => $proteine['id_food'],
                         'starchyPortion' => $feculent['id_food'],
                         'vegetablePortion' => $legume['id_food']
                     ]);
                 }
             }
         }
 
         // Répondre avec un message de réussite
         return 'Les menus ont été générés avec succès.';
 
    }
}

