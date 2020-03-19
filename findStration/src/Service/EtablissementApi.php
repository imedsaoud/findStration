<?php


namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;



class EtablissementApi
{
    public function getEtablissement($postalcode,$type): array
    {
        $HttpClient = HttpClient::create();
        $uri = "https://etablissements-publics.api.gouv.fr/v3/communes/".$postalcode."/".$type;

        try {
            $response = $HttpClient->request('GET', $uri);
        } catch (Exception $e) {
            return ["error" => "Serveur indisponible"];
        }
        $json = $response->getContent();
        return json_decode($json, true);
    }
}
