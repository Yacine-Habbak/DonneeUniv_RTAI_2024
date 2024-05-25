<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Discipline;
use Illuminate\Support\Facades\Log;

class RecupApiController extends Controller
{
    // POUR RECUPERER TOUTES LES DONNEES API
    public function RecupData()
    {
        $this->RecupDataUnivFromApi();
        $this->RecupDataDisciplineFromApi();
        return response()->json(['message' => 'Les données ont été correctement récupéré']);
    }


    // POUR LA TABLE ETABLISSEMENT
    public function RecupDataUnivFromApi()
    {
        $client = new Client(['verify' => false]);
        $startRecord = 0;
        $limit = 100;
        $allData = [];
    
        do {
            try {
                $response = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-principaux-etablissements-enseignement-superieur/records?start={$startRecord}&limit={$limit}");
    
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
    
        foreach ($allData as $item) {
            try {
                $etablissement = new Etablissement();
                $etablissement->Etablissement = $item['uo_lib'];
                $etablissement->Type = is_array($item['type_d_etablissement']) ? implode(', ', $item['type_d_etablissement']) : $item['type_d_etablissement'];
                $etablissement->Commune = $item['com_nom'];
                $etablissement->Departement = $item['dep_nom'] ?? null;
                $etablissement->Region = $item['reg_nom'] ?? null;
                $etablissement->Academie = $item['aca_nom'] ?? null;
                $etablissement->Adresse = $item['adresse_uai'] ?? null;
                $etablissement->Secteur = $item['secteur_d_etablissement'];
                $etablissement->url = $item['url'] ?? null;
                $etablissement->Etudiants_inscrits_2022 = $item['inscrits_2022'] ?? null;
                $etablissement->Etudiants_inscrits_2021 = $item['inscrits_2021'] ?? null;
                $etablissement->Etudiants_inscrits_2020 = $item['inscrits_2020'] ?? null;
                $etablissement->Etudiants_inscrits_2019 = $item['inscrits_2019'] ?? null;
                $etablissement->Etudiants_inscrits_2018 = $item['inscrits_2018'] ?? null;
                $etablissement->siret = is_array($item['siret']) ? implode(', ', $item['siret']) : $item['siret'] ?? null;
                $etablissement->date_creation = $item['date_creation'] ?? null;
                $etablissement->contact = $item['numero_telephone_uai'] ?? null;
                $etablissement->facebook = $item['compte_facebook'] ?? null;
                $etablissement->twitter = $item['compte_twitter'] ?? null;
                $etablissement->instagram = $item['compte_instagram'] ?? null;
                $etablissement->linkedin = $item['compte_linkedin'] ?? null;
                $etablissement->Wikipedia = $item['wikipedia'] ?? null;
    
                $etablissement->save();
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement de l\'établissement: ' . $e->getMessage());
            }
        }
    }
    


    // POUR LA TABLE DISCIPLINE
    public function RecupDataDisciplineFromApi()
    {
        $client = new Client(['verify' => false]);
        $startRecord = 0;
        $limit = 100;
        $allData = [];
    
        do {
            try {
                $response = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-insersup/records?start={$startRecord}&limit={$limit}");
    
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
    

        Discipline::truncate();
    
        foreach ($allData as $item) {
            try {
                $discipline = new Discipline();
                $discipline->Discipline = $item['discipli_lib'];
                $discipline->Etablissement = $item['uo_lib'];
                $discipline->Academie = $item['aca_nom'];
                $discipline->Region = $item['reg_nom'];
                $discipline->Type_diplome = $item['type_diplome_long'];
                $discipline->Nom_diplome = $item['libelle_diplome'];
                $discipline->Nbr_poursuivants = $item['nb_poursuivants'] ?? null;
                $discipline->Nbr_sortants = $item['nb_sortants'] ?? null;
                $discipline->Taux_emploi_salarié = $item['taux_emploi_sal_fr'] ?? null;
                $discipline->Date_insertion = $item['date_inser'] ?? null;
                $discipline->Taux_insertion = $item['taux_insertion'] ?? null;
    
                $discipline->save();
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement de la discipline: ' . $e->getMessage());
            }
        }
    }
    

}