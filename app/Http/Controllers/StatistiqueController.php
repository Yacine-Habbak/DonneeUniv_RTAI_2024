<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Statistique;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class StatistiqueController extends Controller
{
    public function allStatistique()
    {
        $statistique = Statistique::all();
        return view('statistique.index', compact('statistique'));
    }


    // POUR RECUPERER LES DONNEES
    public function RecupDataStatistiqueFromApi()
    {
        $client = new Client(['verify' => false,'timeout' => 300]);
        $startRecord = 0;
        $limit = 100;
        $apikey = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $allData = [];

        do {
            try {
                $response = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-statistiques-sur-les-effectifs-d-etudiants-inscrits-par-espe-inspe/records?start={$startRecord}&limit={$limit}&apikey={$apikey}");

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

        Statistique::truncate();

        foreach ($allData as $item) {
            try {
                $etablissement = Etablissement::where('Etablissement', $item['etablissement_lib'])->first();

                if ($etablissement) {
                    $statistique = new Statistique();
                    $statistique->univ_id = $etablissement->id;
                    $statistique->rentree = $item['rentree'];
                    $statistique->Etudiants_inscrits = $item['effectif_total'];
                    $statistique->Etudiants_inscrits_H = $item['sexem'];
                    $statistique->Etudiants_inscrits_F = $item['sexef'];
                    $statistique->Bac_Gen = $item['baca'] ?? null;
                    $statistique->Bac_STMG = $item['bac4'] ?? null;
                    $statistique->Bac_Autre = $item['bac5'] ?? null;
                    $statistique->Bac_PRO = $item['bac6'] ?? null;
                    $statistique->Bac_Dispense = $item['bac7'] ?? null;
                    $statistique->Etudiants_mobilite = $item['mobilite_internm'] ?? null;
                    $statistique->Bac4 = $item['degetu4'] ?? null;
                    $statistique->Bac5 = $item['degetu5'] ?? null;

                    $statistique->save();
                } else {
                    Log::warning("L'établissement '{$item['etablissement_lib']}' n'existe pas dans la table 'etablissements'.");
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement de la statistique: ' . $e->getMessage());
            }
        }

        return redirect()->route('accueil')
            ->with('Les données des statistiques ont bien été mis à jour.');
    }
}