<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Log;

class RecupApiController extends Controller
{
    public function RecupDataFromApi()
    {
        $client = new Client([
            'verify' => false,
        ]);

        $startRecord = 0;
        $limit = 100;
        $allData = [];

        do {
            $response = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-principaux-etablissements-enseignement-superieur/records?start={$startRecord}&limit={$limit}");

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);

                if (isset($data['results']) && is_array($data['results'])) {
                    $allData = array_merge($allData, $data['results']);
                    $startRecord += $limit;
                } else {
                    Log::error('Invalid data structure received from API.');
                    break;
                }
            } else {
                Log::error('Error retrieving data from API.');
                break;
            }
        } while (count($allData) < $data['total_count']);

        Etablissement::truncate();
        
        foreach ($allData as $item) {
            try {
                $etablissement = new Etablissement();
                $etablissement->Etablissement = $item['uo_lib'];
                $etablissement->Type = is_array($item['type_d_etablissement']) ? implode(', ', $item['type_d_etablissement']) : $item['type_d_etablissement'];
                $etablissement->Commune = $item['com_nom'];
                $etablissement->Secteur = $item['secteur_d_etablissement'];
                $etablissement->Etudiants_inscrits = $item['inscrits_2022'] ?? 0;
        
                $etablissement->save();
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'enregistrement de l\'établissement: ' . $e->getMessage());
            }
        }
        
    }

}