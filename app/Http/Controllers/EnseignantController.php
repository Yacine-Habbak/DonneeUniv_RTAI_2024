<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class EnseignantController extends Controller
{

    // POUR RECUPERER LES DONNEES
    public function RecupDataEnseignantFromApi()
    {
        ini_set('max_execution_time', 0);
        $client = new Client(['verify' => false,'timeout' => 300]);
        $startRecord = 0;
        $limit = 100;
        $apikey = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $allData = [];

        do {
            try {
                $response = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-enseignants-titulaires-esr-public/records?start={$startRecord}&limit={$limit}&apikey={$apikey}");

                if ($response->getStatusCode() == 200) {
                    $data = json_decode($response->getBody(), true);

                    if (isset($data['results']) && is_array($data['results'])) {
                        $allData = array_merge($allData, $data['results']);
                        $startRecord += $limit;
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

        Enseignant::truncate();

        foreach ($allData as $item) {
            try {
                $etablissement = Etablissement::where('Etablissement', $item['etablissement_lib'])->first();

                if ($etablissement) {
                    $enseignant = new Enseignant();
                    $enseignant->univ_id = $etablissement->id;
                    $enseignant->rentree = $item['rentree'];
                    $enseignant->Type_enseignant = $item['categorie_assimilation'];
                    $enseignant->Grande_discipline = $item['grande_discipline'];
                    $enseignant->Sexe = $item['sexe'];
                    $enseignant->Temps = $item['quotite'] ?? null;
                    $enseignant->Effectif = $item['effectif'] ?? null;

                    $enseignant->save();
                } else {
                    Log::warning("L'établissement '{$item['etablissement_lib']}' n'existe pas dans la table 'etablissements'.");
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement de l\'enseignant: ' . $e->getMessage());
            }
        }


        // Mise à jour des enseignants pour chaque établissement
        $etablissements = Etablissement::all();

        foreach ($etablissements as $etablissement) {
            $totalEnseignants = Enseignant::where('univ_id', $etablissement->id)
                                            ->sum('Effectif');

            $etablissement->update([
                'Enseignants' => $totalEnseignants,
            ]);
        }


        return redirect()->route('DataPersonnel')
            ->with('Les données des enseignants ont bien été mis à jour.');
    }
}