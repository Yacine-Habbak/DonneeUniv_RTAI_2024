<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\EnsNonPerm;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class EnsNonPermController extends Controller
{
    public function RecupDataEnsNonPermFromApi()
    {
        ini_set('max_execution_time', 0);
        $client = new Client(['verify' => false, 'timeout' => 300]);
        $debut = 0;
        $limite = 1000;
        $cleApi = '9a63b08bae72b9014f2a17c4c47f428ccec2c5b6d3e97cf7f6aa480e';
        $toutesDonnees = [];
        
        do {
            try {
                $reponse = $client->get("https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/fr-esr-enseignants-nonpermanents-esr-public/records?group_by=etablissement_id_uai%2Ceffectif%2Csexe&refine=rentree%3A%222021%22&start={$debut}&limit={$limite}&apikey={$cleApi}");

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

        $donneesTriees = [];

        foreach ($toutesDonnees as $donnee) {
            $etabLib = $donnee['etablissement_id_uai'];
            $sexe = $donnee['sexe'];
            $effectif = $donnee['effectif'];
        
            if (!isset($donneesTriees[$etabLib])) {
                $donneesTriees[$etabLib] = [
                    'effectif_total' => 0,
                    'effectif_h' => 0,
                    'effectif_f' => 0
                ];
            }
        
            if ($sexe == 'Masculin') {
                $donneesTriees[$etabLib]['effectif_h'] += $effectif;
            } else if ($sexe == 'Féminin') {
                $donneesTriees[$etabLib]['effectif_f'] += $effectif;
            }
        
            $donneesTriees[$etabLib]['effectif_total'] += $effectif;
        }

        EnsNonPerm::truncate();

        foreach ($donneesTriees as $etabLib => $effectifs) {
            $etab = Etablissement::where('id', $etabLib)->first();
        
            if ($etab) {
                try {
                    Log::info("Enregistrement des enseignants non Perm : établissement = {$etab->Etablissement}, total = {$effectifs['effectif_total']}, hommes = {$effectifs['effectif_h']}, femmes = {$effectifs['effectif_f']}");
                    $enseignant = new EnsNonPerm();
                    $enseignant->univ_id = $etab->id;
                    $enseignant->Effectif = $effectifs['effectif_total'];
                    $enseignant->Effectif_H = $effectifs['effectif_h'];
                    $enseignant->Effectif_F = $effectifs['effectif_f'];
                    $enseignant->save();
                } catch (\Exception $e) {
                    Log::error('Erreur lors de l\'enregistrement de l\'enseignant: ' . $e->getMessage());
                }
            } else {
                Log::warning("L'établissement avec l'ID {$etabLib} n'existe pas dans la table 'etablissements'.");
            }
        }

        return redirect()->route('CalculTE')
        ->with('success', 'Les données des enseignants non permanents ont bien été mis à jour.');
    }
}