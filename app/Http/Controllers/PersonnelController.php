<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Personnel;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PersonnelController extends Controller
{


    // POUR RECUPERER LES DONNEES
    public function RecupDataPersonnelFromApi()
    {
        $client = new Client(['verify' => false,'timeout' => 300]);
        $startRecord = 0;
        $limit = 100;
        $apikey = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $allData = [];

        do {
            try {
                $response = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-personnels-biatss-etablissements-publics/records?start={$startRecord}&limit={$limit}&apikey={$apikey}");

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

        Personnel::truncate();

        foreach ($allData as $item) {
            try {
                $etablissement = Etablissement::where('Etablissement', $item['etablissement_lib'])->first();

                if ($etablissement) {
                    $personnel = new Personnel();
                    $personnel->univ_id = $etablissement->id;
                    $personnel->rentree = $item['rentree'];
                    $personnel->Type_personnel = $item['type_personnel'];
                    $personnel->Corps = $item['corps_lib'];
                    $personnel->Classe_Age = $item['classe_age3'] ?? null;
                    $personnel->Effectif = $item['effectif'];
                    $personnel->Effectif_H = $item['effectif_hommes'];
                    $personnel->Effectif_F = $item['effectif_femmes'];

                    $personnel->save();
                } else {
                    Log::warning("L'établissement '{$item['etablissement_lib']}' n'existe pas dans la table 'etablissements'.");
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement du personnel: ' . $e->getMessage());
            }
        }

        return redirect()->route('DataStatistique')
            ->with('Les données des personnels ont bien été mis à jour.');
    }
}