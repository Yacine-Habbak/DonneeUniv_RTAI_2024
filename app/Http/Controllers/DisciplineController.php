<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Discipline;
use App\Models\Diplome;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DisciplineController extends Controller
{
    public function allDiscipline()
    {
        $disciplines = Discipline::all();
        return view('disciplines.all', compact('disciplines'));
    }

    // Récupérer les données
    public function RecupDataDisciplineFromApi()
    {
        ini_set('max_execution_time', 0);
        $client = new Client(['verify' => false, 'timeout' => 300]);
        $debut = 0;
        $limite = 1000;
        $cleApi = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $toutesDonnees = [];
        
        do {
            try {
                $reponse = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-insersup/records?group_by=etablissement%2Cdiscipli_lib%2Ctype_diplome_long%2Clibelle_diplome%2Cnb_poursuivants%2Cnb_sortants&refine=source%3A%22insersup%22&start={$debut}&limit={$limite}&apikey={$cleApi}");

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

        $etabDisciplines = [];
        $etabDiplomes = [];

        foreach ($toutesDonnees as $element) {
            $nomEtab = $element['etablissement'];
            $discipline = $element['discipli_lib'];

            if ($discipline === 'Toutes disciplines') {
                continue;
            }

            if (!isset($etabDisciplines[$nomEtab])) {
                $etabDisciplines[$nomEtab] = [];
            }

            if (!in_array($discipline, $etabDisciplines[$nomEtab])) {
                $etabDisciplines[$nomEtab][] = $discipline;
            }

            $typeDiplome = $element['type_diplome_long'] ?? null;
            $libelleDiplome = $element['libelle_diplome'] ?? null;
            $nbPoursuivants = $element['nb_poursuivants'] ?? 0;
            $nbSortants = $element['nb_sortants'] ?? 0;

            if (!isset($etabDiplomes[$nomEtab])) {
                $etabDiplomes[$nomEtab] = [];
            }

            if (!isset($etabDiplomes[$nomEtab][$typeDiplome])) {
                $etabDiplomes[$nomEtab][$typeDiplome] = [];
            }

            if (!isset($etabDiplomes[$nomEtab][$typeDiplome][$libelleDiplome])) {
                $etabDiplomes[$nomEtab][$typeDiplome][$libelleDiplome] = [
                    'nbr_Pour' => 0,
                    'nbr_Sort' => 0,
                ];
            }

            $etabDiplomes[$nomEtab][$typeDiplome][$libelleDiplome]['nbr_Pour'] += $nbPoursuivants;
            $etabDiplomes[$nomEtab][$typeDiplome][$libelleDiplome]['nbr_Sort'] += $nbSortants;
        }

        Discipline::truncate();
        
        foreach ($etabDisciplines as $nomEtab => $disciplines) {
            try {
                $etablissement = Etablissement::where('id', $nomEtab)->first();
                if ($etablissement) {
                    $discipline = new Discipline();
                    $discipline->univ_id = $etablissement->id;
                    $discipline->Discipline = implode('//', $disciplines);
                    $discipline->save();
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement des données de l\'API : ' . $e->getMessage());
            }
        }

        Diplome::truncate();

        foreach ($etabDiplomes as $nomEtab => $types) {
            try {
                $etablissement = Etablissement::where('id', $nomEtab)->first();
                if ($etablissement) {
                    foreach ($types as $type => $diplomes) {
                        foreach ($diplomes as $libelle => $data) {
                            $diplome = new Diplome();
                            $diplome->univ_id = $etablissement->id;
                            $diplome->Type = $type;
                            $diplome->Diplome = $libelle;
                            $diplome->nbr_Pour = $data['nbr_Pour'];
                            $diplome->nbr_Sort = $data['nbr_Sort'];
                            $diplome->save();
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement des données de l\'API : ' . $e->getMessage());
            }
        }

        return redirect()->route('DataStatistique')
        ->with('success', 'Les disciplines et les diplômes ont bien été mis à jour.');
    }
}