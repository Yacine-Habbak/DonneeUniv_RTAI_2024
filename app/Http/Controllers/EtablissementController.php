<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class EtablissementController extends Controller
{
    public function allEtablissement()
    {
        $etablissements = Etablissement::all();
        return view('etablissements.all', compact('etablissements'));
    }

    public function allEtablissementAcad($academie)
    {
        $etablissements = Etablissement::all();
    
        $filteredEtablissements = $etablissements->filter(function ($etablissement) use ($academie) {
            return strpos($academie, $etablissement->Academie) !== false;
        });
    
        return view('etablissements.all', [
            'etablissements' => $filteredEtablissements,
            'academie' => $academie
        ]);
    }
    

    public function showEtablissement($id)
    {
        $etablissement = Etablissement::findOrFail($id);
        return view('etablissements.show', compact('etablissement'));
    }

    public function index()
    {
        $etablissements = Etablissement::all();
        return response()->json($etablissements);
    }

    public function RecupDataUnivFromApi()
    {
        ini_set('max_execution_time', 0);
        $client = new Client(['verify' => false,'timeout' => 300]);
	    $startRecord = 0;
        $limit = 100;
        $apikey = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $allData = [];
        
        do {
            try {
                $response = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-principaux-etablissements-enseignement-superieur/records?start={$startRecord}&limit={$limit}&apikey={$apikey}");
    
                if ($response->getStatusCode() == 200) {
                    $data = json_decode($response->getBody(), true);

                    if (isset($data['results']) && is_array($data['results'])) {
                        $allData = array_merge($allData, $data['results']);
			            $startRecord += $limit;
                    } else {
                        Log::error('Structure de donnée incorrecte recue par l\'API');
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

        Etablissement::truncate();
        Etudiant::truncate();

        foreach ($allData as $element) {
            try {
                $etablissement = new Etablissement();
                $etablissement->id = $element['uai'];
                $etablissement->Etablissement = $element['uo_lib'];
                $etablissement->Type = is_array($element['type_d_etablissement']) ? implode(', ', $element['type_d_etablissement']) : $element['type_d_etablissement'];
                $etablissement->Commune = $element['com_nom'];
                $etablissement->Departement = $element['dep_nom'] ?? null;
                $etablissement->Region = $element['reg_nom'] ?? null;
                $etablissement->Academie = $element['aca_nom'] ?? null;
                $etablissement->Adresse = $element['adresse_uai'] ?? null;
                $etablissement->lon = $element['coordonnees']['lon'];
                $etablissement->lat = $element['coordonnees']['lat'];
                $etablissement->Secteur = $element['secteur_d_etablissement'];
                $etablissement->url = $element['url'] ?? null;
                $etablissement->siret = is_array($element['siret']) ? implode(', ', $element['siret']) : $element['siret'] ?? null;
                $etablissement->date_creation = $element['date_creation'] ?? null;
                $etablissement->contact = $element['numero_telephone_uai'] ?? null;
                $etablissement->facebook = $element['compte_facebook'] ?? null;
                $etablissement->twitter = $element['compte_twitter'] ?? null;
                $etablissement->instagram = $element['compte_instagram'] ?? null;
                $etablissement->linkedin = $element['compte_linkedin'] ?? null;
                $etablissement->Wikipedia = $element['wikipedia'] ?? null;
                $etablissement->save();

                $etudiant = new Etudiant();
                $etudiant->univ_id = $element['uai'];
                $etudiant->Effectif_2022 = $element['inscrits_2022'] ?? null;
                $etudiant->Effectif_2021 = $element['inscrits_2021'] ?? null;
                $etudiant->Effectif_2020 = $element['inscrits_2020'] ?? null;
                $etudiant->Effectif_2019 = $element['inscrits_2019'] ?? null;
                $etudiant->Effectif_2018 = $element['inscrits_2018'] ?? null;
                $etudiant->Effectif_2017 = $element['inscrits_2017'] ?? null;
                $etudiant->Effectif_2016 = $element['inscrits_2016'] ?? null;
                $etudiant->Effectif_2015 = $element['inscrits_2015'] ?? null;
                $etudiant->Effectif_2014 = $element['inscrits_2014'] ?? null;
                $etudiant->Effectif_2013 = $element['inscrits_2013'] ?? null;
                $etudiant->save();

            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement de l\'établissement: ' . $e->getMessage());
            }

        }

        return redirect()->route('DataPersonnel')
        ->with('success', 'Les etablissements ont bien été mis à jour.');
    }

    public function CalculTE()
    {
        $etablissements = Etablissement::with('etudiants')->get();
    
        foreach ($etablissements as $etablissement) {
            try {
                
                if ($etablissement->etudiants) {
                    $etudiant = $etablissement->etudiants;
                    if ($etablissement->Enseignants && $etudiant->Effectif_2021) {
                        $etablissement->TE_enseignants = ($etablissement->Enseignants * 1000) / $etudiant->Effectif_2021;
                        if ($etablissement->Personnels_non_enseignant) {
                            $etablissement->TE_Total = (($etablissement->Personnels_non_enseignant + $etablissement->Enseignants) * 1000) / $etudiant->Effectif_2021;
                        }
                        $etablissement->save();
                    }
                    else if ($etablissement->Enseignants && $etudiant->Effectif_2022) {
                        $etablissement->TE_enseignants = ($etablissement->Enseignants * 1000) / $etudiant->Effectif_2022;
                        if ($etablissement->Personnels_non_enseignant) {
                            $etablissement->TE_Total = (($etablissement->Personnels_non_enseignant + $etablissement->Enseignants) * 1000) / $etudiant->Effectif_2022;
                        }
                        $etablissement->save();
                    }
                }
            } catch (\Exception $e) {
                \Log::error("Erreur lors du calcul du taux d'encadrement de : {$etablissement->Etablissement} - " . $e->getMessage());
            }
        }

        return redirect()->route('DataDiscipline')
        ->with('success', 'Les taux d\'encadrement ont bien été mis à jour.');
    }


    public function carte()
    {
        $coordonnes = Etablissement::select('lat', 'lon', 'Etablissement', 'Type', 'Secteur')->get();
        return view('carteEtab', ['coordonnes' => $coordonnes]);

    }
    


}