<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;


class GeoApi
{
    public function getCommune($cityName,$postalcode): array
    {
        $HttpClient = HttpClient::create();

        $uri = "https://geo.api.gouv.fr/communes?codePostal=".$postalcode."&nom=".$cityName."&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre";

        try {
            $response = $HttpClient->request('GET', $uri);
        } catch (Exception $e) {
            return ["error" => "Serveur indisponible"];
        }
        $json = $response->getContent();
        return json_decode($json, true);
    }
}
