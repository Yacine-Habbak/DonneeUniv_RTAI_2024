<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Personnel;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PersonnelController extends Controller
{
    public function RecupDataPersonnelFromApi()
    {
        ini_set('max_execution_time', 0);
        $client = new Client(['verify' => false, 'timeout' => 300]);
        $debut = 0;
        $limite = 1000;
        $cleApi = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $toutesDonnees = [];
        
        do {
            try {
                $reponse = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-personnels-biatss-etablissements-publics/records?group_by=etablissement_lib%2Ctype_personnel%2Ceffectif%2Ceffectif_hommes%2Ceffectif_femmes&refine=rentree%3A%222021%22&start={$debut}&limit={$limite}&apikey={$cleApi}");

                if ($reponse->getStatusCode() == 200) {
                    $data = json_decode($reponse->getBody(), true);

                    if (isset($data['results']) && is_array($data['results'])) {
                        $toutesDonnees = array_merge($toutesDonnees, $data['results']);
                        $debut += $limite;
                    } else {
                        Log::error('Structure de donnée incorrecte reçue par l\'API');
                        break;
                    }
                } else {
                    Log::error('Erreur de transfert de donnée depuis l\'API');
                    break;
                }
            } catch (\Exception $e) {
                Log::error('Erreur de transfert de donnée depuis l\'API : ' . $e->getMessage());
                break;
            }
        } while (!empty($data['results']));

        // Tableau pour stocker les données agrégées
        $donneeTriee = [];

        foreach ($toutesDonnees as $donnee) {
            $etabLib = $donnee['etablissement_lib'];
            $typePers = $donnee['type_personnel'];
            
            if (!isset($donneeTriee[$etabLib])) {
                $donneeTriee[$etabLib] = [
                    'titulaires' => [
                        'effectif' => 0,
                        'effectif_h' => 0,
                        'effectif_f' => 0
                    ],
                    'contractuels' => [
                        'effectif' => 0,
                        'effectif_h' => 0,
                        'effectif_f' => 0
                    ],
                    'totaux' => [
                        'effectif' => 0,
                        'effectif_h' => 0,
                        'effectif_f' => 0
                    ]
                ];
            }

            $donneeTriee[$etabLib][$typePers]['effectif'] += $donnee['effectif'];
            $donneeTriee[$etabLib][$typePers]['effectif_h'] += $donnee['effectif_hommes'];
            $donneeTriee[$etabLib][$typePers]['effectif_f'] += $donnee['effectif_femmes'];

            // Calcul des totaux
            $donneeTriee[$etabLib]['totaux']['effectif'] += $donnee['effectif'];
            $donneeTriee[$etabLib]['totaux']['effectif_h'] += $donnee['effectif_hommes'];
            $donneeTriee[$etabLib]['totaux']['effectif_f'] += $donnee['effectif_femmes'];
        }

        Personnel::truncate();

        foreach ($donneeTriee as $etabLib => $typesPers) {
            $etab = Etablissement::where('Etablissement', $etabLib)->first();

            if ($etab) {
                foreach ($typesPers as $typePers => $effectifs) {
                    if ($typePers !== 'totaux') {
                        try {
                            $pers = new Personnel();
                            $pers->univ_id = $etab->id;
                            $pers->Type = $typePers;
                            $pers->Effectif = $effectifs['effectif'];
                            $pers->Effectif_H = $effectifs['effectif_h'];
                            $pers->Effectif_F = $effectifs['effectif_f'];
                            $pers->save();
                        } catch (\Exception $e) {
                            Log::error('Erreur lors de l\'enregistrement du personnel: ' . $e->getMessage());
                        }
                    }
                }

                // Mise à jour des totaux dans la table Etablissement
                try {
                    $etab->Personnels_non_enseignant = $typesPers['totaux']['effectif'];
                    $etab->Personnels_non_enseignant_H = $typesPers['totaux']['effectif_h'];
                    $etab->Personnels_non_enseignant_F = $typesPers['totaux']['effectif_f'];
                    $etab->save();
                } catch (\Exception $e) {
                    Log::error("Erreur lors de la mise à jour des totaux pour l'établissement '{$etabLib}': " . $e->getMessage());
                }
            } else {
                Log::warning("L'établissement '{$etabLib}' n'existe pas dans la table 'etablissements'.");
            }
        }

        return redirect()->route('DataEnseignant')
        ->with('success', 'Les données des personnels ont bien été mis à jour.');
    }
}