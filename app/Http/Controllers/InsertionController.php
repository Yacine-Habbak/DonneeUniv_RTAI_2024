<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Discipline;
use App\Models\Diplome;
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

        $toutesDonnees = [];

        do {
            try {
                $reponse = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-insersup/records?group_by=etablissement%2Cdiscipli_lib%2Ctype_diplome_long%2Clibelle_diplome%2Ctaux_insertion&refine=source%3A%22IP%22&refine=date_inser_long%3A%2218%20mois%20apr%C3%A8s%20le%20dipl%C3%B4me%22&start={$debut}&limit={$limite}&apikey={$cleApi}");
                if ($reponse->getStatusCode() == 200) {
                    $data = json_decode($reponse->getBody(), true);
                    if (isset($data['results']) && is_array($data['results'])) {
                        $toutesDonnees = array_merge($toutesDonnees, $data['results']);
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

        $etabDisciplines = [];

        Insertion::truncate();
    
        foreach ($toutesDonnees as $element) {
            try {
                $discipline = Discipline::where('univ_id', $element['etablissement'])
                ->exists();
                if (!$discipline){
                    $nomEtab = $element['etablissement'];
                    $discipline = $element['discipli_lib'];
    
                    if ($discipline != 'Toutes disciplines') {
                        if (!isset($etabDisciplines[$nomEtab])) {
                            $etabDisciplines[$nomEtab] = [];
                        }
        
                        if (!in_array($discipline, $etabDisciplines[$nomEtab])) {
                            $etabDisciplines[$nomEtab][] = $discipline;
                        }
                    }
                }


                $etablissement = Etablissement::where('id', $element['etablissement'])->first();
                if ($etablissement) {
                    $diplomes = Diplome::where('univ_id', $element['etablissement'])
                    ->where('Type', $element['type_diplome_long'])
                    ->where('Diplome', $element['libelle_diplome'])
                    ->exists();
 
                    if ((!$diplomes) && ($element['libelle_diplome'] != 'Toute licence professionnelle') && ($element['libelle_diplome'] != 'Tout Master LMD') && ($element['libelle_diplome'] != 'Tout Master MEEF')) {
                        $diplome = new Diplome();
                        $diplome->univ_id = $etablissement->id;
                        $diplome->Type = $element['type_diplome_long'];
                        $diplome->Diplome = $element['libelle_diplome'];
                        $diplome->save();
                    }



                    $insertion = Insertion::firstOrNew(['univ_id' => $etablissement->id]);
                    $insertion->univ_id = $etablissement->id;
                    $taux_insertion = $element['taux_insertion'];
                    
                    if (is_numeric($taux_insertion)) {
                        if ($element['libelle_diplome'] == 'Toute licence professionnelle') {
                            $insertion->inser_Licence = $taux_insertion;
                        } elseif ($element['libelle_diplome'] == 'Tout Master LMD') {
                            $insertion->inser_Master_LMD = $taux_insertion;
                        } elseif ($element['libelle_diplome'] == 'Tout Master MEEF') {
                            $insertion->inser_Master_MEEF = $taux_insertion;
                        } else {
                            $diplome = Diplome::where('univ_id', $element['etablissement'])
                                ->where('Diplome', $element['libelle_diplome'])
                                ->first();
                            if ($diplome) {
                                $diplome->TI = $taux_insertion;
                                $diplome->save();
                            }
                        }
                        $insertion->save();
                    }
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement des données de l\'API : ' . $e->getMessage());
            }
        }

        foreach ($etabDisciplines as $nomEtab => $disciplines) {
            try {
                    $discipline = new Discipline();
                    $discipline->univ_id = $nomEtab;
                    $discipline->Discipline = implode('//', $disciplines);
                    $discipline->save();
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement des données de l\'API : ' . $e->getMessage());
            }
        }
        

        return redirect()->route('accueil')
        ->with('success', 'Les données des insertions ont bien été mises à jour.');

    }
}