<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Insertion;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class InsertionController extends Controller
{
    public function RecupDataInsertionFromApi()
    {
        ini_set('max_execution_time', 0);
        $client = new Client(['verify' => false, 'timeout' => 300]);
        $debut = 0;
        $limite = 1000;
        $cleApi = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';

        $donneesLp = [];
        $donneesMaster = [];

        // 1ere API
        do {
            try {
                $reponse = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-insertion_professionnelle-lp/records?group_by=numero_de_l_etablissement%2Ctaux_dinsertion&refine=situation%3A%2218%20mois%20apr%C3%A8s%20le%20dipl%C3%B4me%22&refine=annee%3A%222020%22&start={$debut}&limit={$limite}&apikey={$cleApi}");
                if ($reponse->getStatusCode() == 200) {
                    $data = json_decode($reponse->getBody(), true);
                    if (isset($data['results']) && is_array($data['results'])) {
                        $donneesLp = array_merge($donneesLp, $data['results']);
                        $debut += $limite;
                    } else {
                        Log::error('Structure de données incorrecte reçue de l\'API');
                        break;
                    }
                } else {
                    Log::error('Erreur lors du transfert de données depuis l\'API');
                    break;
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors du transfert de données depuis l\'API : ' . $e->getMessage());
                break;
            }
        } while (!empty($data['results']));

        $debut = 0;

        // 2eme API
        do {
            try {
                $reponse = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-insertion_professionnelle-master/records?group_by=numero_de_l_etablissement%2Ctaux_dinsertion&refine=annee%3A%222020%22&refine=situation%3A%2218%20mois%20apr%C3%A8s%20le%20dipl%C3%B4me%22&start={$debut}&limit={$limite}&apikey={$cleApi}");
                if ($reponse->getStatusCode() == 200) {
                    $data = json_decode($reponse->getBody(), true);
                    if (isset($data['results']) && is_array($data['results'])) {
                        $donneesMaster = array_merge($donneesMaster, $data['results']);
                        $debut += $limite;
                    } else {
                        Log::error('Structure de données incorrecte reçue de l\'API');
                        break;
                    }
                } else {
                    Log::error('Erreur lors du transfert de données depuis l\'API');
                    break;
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors du transfert de données depuis l\'API : ' . $e->getMessage());
                break;
            }
        } while (!empty($data['results']));

        Insertion::truncate();

        $etabs = Etablissement::pluck('id')->toArray();
        $dataInsert = [];

        // Calculer la moyenne de la 1ere API
        $groupesLp = [];
        foreach ($donneesLp as $item) {
            $id = $item['numero_de_l_etablissement'];
            $taux = $item['taux_dinsertion'];

            if (!isset($groupesLp[$id])) {
                $groupesLp[$id] = [];
            }

            if ($taux !== 'ns') {
                $groupesLp[$id][] = (int) $taux;
            }
        }

        $moyennesLp = [];
        foreach ($groupesLp as $id => $tauxArray) {
            if (!empty($tauxArray)) {
                $moyenne = array_sum($tauxArray) / count($tauxArray);
                $moyennesLp[$id] = round($moyenne, 1);
            }
        }

        // Calculer la moyenne de la 2eme API
        $groupesMaster = [];
        foreach ($donneesMaster as $item) {
            $id = $item['numero_de_l_etablissement'];
            $taux = $item['taux_dinsertion'];

            if (!isset($groupesMaster[$id])) {
                $groupesMaster[$id] = [];
            }

            if ($taux !== 'ns') {
                $groupesMaster[$id][] = (int) $taux;
            }
        }

        $moyennesMaster = [];
        foreach ($groupesMaster as $id => $tauxArray) {
            if (!empty($tauxArray)) {
                $moyenne = array_sum($tauxArray) / count($tauxArray);
                $moyennesMaster[$id] = round($moyenne, 1);
            }
        }

        foreach ($moyennesLp as $id => $moyenneLicence) {
            if (in_array($id, $etabs)) {
                $insertion = new Insertion();
                $insertion->univ_id = $id;
                $insertion->inser_Licence = $moyenneLicence == 0 ? null : $moyenneLicence;
                $insertion->inser_Master = $moyennesMaster[$id] ?? null;
                $insertion->save(); 
            }
        }        

        return redirect()->route('accueil')
        ->with('success', 'Les données des insertions ont bien été mises à jour.');

    }
}