<?php

namespace App\Repositories;

use App\Models\Secteur;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SecteurRepository
{
    public function getAllSecteur()
    {
        return Secteur::all();
    }

    public function getPartenaireBySecteur($id)
    {
        $secteur = Secteur::findOrFail($id);
        $user = $secteur->partenaires;
        $Partenaires = $user->map(function ($singleUse) use ($user) {
            return [
                "profession" => $singleUse->profession->nom,
                "ville" => $singleUse->ville->nom,
                "specialite" => $singleUse->specialite->nom,
                "gouvernerat" => $singleUse->ville->gouvernerat->nom,
                "nom" => $singleUse->nom,
                "prenom" => $singleUse->prenom,
                "nom_responsable" => $singleUse->nom_responable,
                "email" => $singleUse->email,
                "image" => $singleUse->image,
                "cin" => $singleUse->cin,
                "numero" => $singleUse->numero,
                "adresse" => $singleUse->adresse,
            ];
        });
        return $Partenaires;
    }

    public function getAllPartenaires($params)
    {
        $partenaire = User::whereIn('role_id', [2, 3]);

        if ($params) {
            return $this->filterPartenaires($partenaire, $params);
        }
        $partenairesUsers = $partenaire->get();

        $users = $partenairesUsers->map(function ($user) {

            return [
                "secteur_id" => $user->id ?? 'N/A',
                "ville_id" => $user->ville_id ?? 'N/A',
                "gouvernerat_id" => $user->ville->gouvernerat->id ?? 'N/A',

                "profession" => $user->profession->nom ?? 'N/A',
                "secteur" => $user->secteur_id->nom ?? 'N/A',
                "ville" => $user->ville->nom ?? 'N/A',
                "specialite" => $user->specialite->nom ?? 'N/A',
                "gouvernerat" => $user->ville->gouvernerat->nom ?? 'N/A',

                "nom_responsable" => $user->nom_responable ?? 'N/A',
                "email" => $user->email,
                "image" => $user->image,
                "cin" => $user->cin,
                "numero" => $user->numero,
                "adresse" => $user->adresse,

            ];

        }
        );
        return $users;
    }


    protected function filterPartenaires($partenaireUsers, $params)
    {
        foreach ($params as $key => $value) {
            switch ($key) {
                case 'villeId':
                    $partenaireUsers->ByVilleId($value);
                    break;
                case 'gouverneratId':
                    $partenaireUsers->ByGouverneratId($value);
                    break;
                case 'secteurId':
                    $partenaireUsers->BySecteurId($value);
                    break;
                default:
                    break;
            }
        }
        $partenaires = $partenaireUsers->get();

        $users = $partenaires->map(function ($user) {
            return [
                "secteur_id" => $user->id ?? 'N/A',
                "ville_id" => $user->ville_id ?? 'N/A',
                "gouvernerat_id" => $user->ville->gouvernerat->id ?? 'N/A',
                "profession" => $user->profession->nom ?? 'N/A',
                "secteur" => $user->secteur_id->nom ?? 'N/A',
                "ville" => $user->ville->nom ?? 'N/A',
                "specialite" => $user->specialite->nom ?? 'N/A',
                "gouvernerat" => $user->ville->gouvernerat->nom ?? 'N/A',
                "nom_responsable" => $user->nom_responable ?? 'N/A',
                "email" => $user->email,
                "image" => $user->image,
                "cin" => $user->cin,
                "numero" => $user->numero,
                "adresse" => $user->adresse,

            ];
        }
        );
        return $users;
    }
}
