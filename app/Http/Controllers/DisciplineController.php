<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Discipline;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DisciplineController extends Controller
{
    public function allDiscipline()
    {
        $discipline = Discipline::all();
        return view('disciplines.all', compact('discipline'));
    }


    // POUR RECUPERER LES DONNEES
    public function RecupDataDisciplineFromApi()
    {
        $client = new Client(['verify' => false,'timeout' => 300]);
        $startRecord = 0;
        $limit = 100;
        $apikey = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $allData = [];

        do {
            try {
                $response = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-insersup/records?start={$startRecord}&limit={$limit}&apikey={$apikey}");

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

        Discipline::truncate();

        foreach ($allData as $item) {
            try {
                $etablissement = Etablissement::where('Etablissement', $item['uo_lib'])->first();

                if ($etablissement) {
                    $discipline = new Discipline();
                    $discipline->univ_id = $etablissement->id;
                    $discipline->Discipline = $item['discipli_lib'];
                    $discipline->Type_diplome = $item['type_diplome_long'];
                    $discipline->Nom_diplome = $item['libelle_diplome'];
                    $discipline->Nbr_poursuivants = $item['nb_poursuivants'] ?? null;
                    $discipline->Nbr_sortants = $item['nb_sortants'] ?? null;
                    $discipline->Taux_emploi_salarié = $item['taux_emploi_sal_fr'] ?? null;
                    $discipline->Date_insertion = $item['date_inser'] ?? null;
                    $discipline->Taux_insertion = $item['taux_insertion'] ?? null;

                    $discipline->save();
                } else {
                    Log::warning("L'établissement '{$item['uo_lib']}' n'existe pas dans la table 'etablissements'.");
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement de la discipline: ' . $e->getMessage());
            }
        }

        return redirect()->route('DataEnseignant')
            ->with('Les données des disciplines ont bien été mis à jour.');
    }
}