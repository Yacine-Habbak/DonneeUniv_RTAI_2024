<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class EtablissementController extends Controller
{
    public function allEtablissement()
    {
        $etablissement = Etablissement::all();
        return view('etablissements.all', compact('etablissement'));
    }


    // POUR RECUPERER LES DONNEES
    public function RecupDataUnivFromApi()
    {
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

        return redirect()->route('DataDiscipline')
            ->with('Les données des établissements ont bien été mis à jour.');
    }
}