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
        $debut = 0;
        $limit = 400;
        $cleApi = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $toutesLesDonnees = [];

        do {
            try {
                $reponse = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-statistiques-sur-les-effectifs-d-etudiants-inscrits-par-espe-inspe/records?group_by=etablissement_lib%2Crentree%2Ceffectif_total%2Csexem%2Csexef%2Cbaca%2Cbac4%2Cbac5%2Cbac6%2Cbac7%2Cbac_ageavance%2Cbac_agea_l_heure%2Cbac_ageretard%2Cgd_discisciplinedsa%2Cgd_discisciplinellsh%2Cgd_discisciplinesi%2Cgd_discisciplinestaps%2Cdiscipline02%2Cdiscipline04%2Cdiscipline05%2Cdiscipline32%2Cdiscipline09%2Cdiscipline10%2Cmobilite_internm%2Cdegetu4%2Cdegetu5&start={$debut}&limit={$limit}&apikey={$cleApi}");

                if ($reponse->getStatusCode() == 200) {
                    $data = json_decode($reponse->getBody(), true);

                    if (isset($data['results']) && is_array($data['results'])) {
                        $toutesLesDonnees = array_merge($toutesLesDonnees, $data['results']);
                        $debut += $limit;
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

        foreach ($toutesLesDonnees as $donnee) {
            try {
                $etablissement = Etablissement::where('Etablissement', $donnee['etablissement_lib'])->first();

                if ($etablissement) {
                    $statistique = new Statistique();
                    $statistique->univ_id = $etablissement->id;
                    $statistique->Rentree = $donnee['rentree'];
                    $statistique->Etudiants_inscrits = $donnee['effectif_total'];
                    $statistique->Etudiants_inscrits_H = $donnee['sexem'];
                    $statistique->Etudiants_inscrits_F = $donnee['sexef'];
                    $statistique->Bac_Gen = $donnee['baca'];
                    $statistique->Bac_STMG = $donnee['bac4'];
                    $statistique->Bac_Autre = $donnee['bac5'];
                    $statistique->Bac_PRO = $donnee['bac6'];
                    $statistique->Bac_Dispense = $donnee['bac7'];
                    $statistique->Avance_bac = $donnee['bac_ageavance'];
                    $statistique->Alheure_bac = $donnee['bac_agea_l_heure'];
                    $statistique->Retard_bac = $donnee['bac_ageretard'];
                    $statistique->G_Droit = $donnee['gd_discisciplinedsa'];
                    $statistique->G_Lettre_langues = $donnee['gd_discisciplinellsh'];
                    $statistique->G_Science_inge = $donnee['gd_discisciplinesi'];
                    $statistique->G_STAPS = $donnee['gd_discisciplinestaps'];
                    $statistique->Science_eco = $donnee['discipline02'];
                    $statistique->lettre_science = $donnee['discipline04'];
                    $statistique->Langue = $donnee['discipline05'];
                    $statistique->Science_hu = $donnee['discipline32'];
                    $statistique->Science_vie = $donnee['discipline09'];
                    $statistique->Science_Fo = $donnee['discipline10'];
                    $statistique->Etudiants_mobilite = $donnee['mobilite_internm'];
                    $statistique->Bac4 = $donnee['degetu4'];
                    $statistique->Bac5 = $donnee['degetu5'];

                    $statistique->save();
                } else {
                    Log::warning("L'établissement '{$donnee['etablissement_lib']}' n'existe pas dans la table 'etablissements'.");
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement de la statistique: ' . $e->getMessage());
            }
        }

        return redirect()->route('DataInsertion')
        ->with('success', 'Les données des statistiques ont bien été mis à jour.');


    }
}