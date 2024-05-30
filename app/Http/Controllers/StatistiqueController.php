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
        $etablissements = Etablissement::all();
        $statistiques = Statistique::with('etablissement')->get();
        return view('statistiques.index', compact('statistiques','etablissements'));
    }


    // POUR RECUPERER LES DONNEES
    public function RecupDataStatistiqueFromApi()
    {
        ini_set('max_execution_time', 0);
        $client = new Client(['verify' => false,'timeout' => 300]);
        $startRecord = 0;
        $limit = 400;
        $apikey = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $allData = [];

        do {
            try {
                $response = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-statistiques-sur-les-effectifs-d-etudiants-inscrits-par-espe-inspe/records?group_by=etablissement_lib%2Crentree%2Ceffectif_total%2Csexem%2Csexef%2Cbaca%2Cbac4%2Cbac5%2Cbac6%2Cbac7%2Cbac_ageavance%2Cbac_agea_l_heure%2Cbac_ageretard%2Cgd_discisciplinedsa%2Cgd_discisciplinellsh%2Cgd_discisciplinesi%2Cgd_discisciplinestaps%2Cdiscipline02%2Cdiscipline04%2Cdiscipline05%2Cdiscipline32%2Cdiscipline09%2Cdiscipline10%2Cmobilite_internm%2Cdegetu4%2Cdegetu5&start={$startRecord}&limit={$limit}&apikey={$apikey}");

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
                    $statistique->Bac_Gen = $item['baca'];
                    $statistique->Bac_STMG = $item['bac4'];
                    $statistique->Bac_Autre = $item['bac5'];
                    $statistique->Bac_PRO = $item['bac6'];
                    $statistique->Bac_Dispense = $item['bac7'];
                    $statistique->Avance_bac = $item['bac_ageavance'];
                    $statistique->Alheure_bac = $item['bac_agea_l_heure'];
                    $statistique->Retard_bac = $item['bac_ageretard'];
                    $statistique->G_Droit = $item['gd_discisciplinedsa'];
                    $statistique->G_Lettre_langues = $item['gd_discisciplinellsh'];
                    $statistique->G_Science_inge = $item['gd_discisciplinesi'];
                    $statistique->G_STAPS = $item['gd_discisciplinestaps'];
                    $statistique->Science_eco = $item['discipline02'];
                    $statistique->lettre_science = $item['discipline04'];
                    $statistique->Langue = $item['discipline05'];
                    $statistique->Science_hu = $item['discipline32'];
                    $statistique->Science_vie = $item['discipline09'];
                    $statistique->Science_Fo = $item['discipline10'];
                    $statistique->Etudiants_mobilite = $item['mobilite_internm'];
                    $statistique->Bac4 = $item['degetu4'];
                    $statistique->Bac5 = $item['degetu5'];

                    $statistique->save();
                } else {
                    Log::warning("L'établissement '{$item['etablissement_lib']}' n'existe pas dans la table 'etablissements'.");
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement de la statistique: ' . $e->getMessage());
            }
        }

        return redirect()->route('CalculTE')
            ->with('Les données des statistiques ont bien été mis à jour.');
    }
}