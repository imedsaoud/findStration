<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GeoApi;
use App\Service\EtablissementApi;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param GeoAPi $geoAPi
     * @param EtablissementApi $etablissementApi
     */
    public function index(GeoAPi $geoAPi, EtablissementApi $etablissementApi)
    {
        $foundedCity = [];
        $etablishments = [];
        if($_GET !== []){
            $city= $_GET["city"];
            $postalCode= $_GET["postal_code"];
            $citys = $geoAPi->getCommune($city,$postalCode);
            foreach ($citys as $city) {
                $etablishments = $etablissementApi->getEtablissement($city['code'], $_GET["type"]);
                if($etablishments != null){
                    $city["etablissement"] = $etablishments;
                }
                array_push($foundedCity,$city);
            }

            return $this->render('home.html.twig', [
                'villes' => $foundedCity,
                'ville' => $_GET["city"],
                'codePostal' => $_GET["postal_code"],
            ]);
        }
        return $this->render('home.html.twig', [
            'villes' => $foundedCity,
            'ville' => "",
            'codePostal' => "",
        ]);
    }
}
