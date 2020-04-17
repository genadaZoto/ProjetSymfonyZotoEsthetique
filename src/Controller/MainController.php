<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=Brussels,Belgium&units=metric&appid=7781f04cd5015c433d348665c021f6b3');
        $content = $response->toArray();

        $weather = $content["weather"][0]["main"];
        $weatherIcon = $content["weather"][0]["icon"];
        $temp = $content["main"]["temp"];
        $wind = $content["wind"]["speed"];
        $today = date("m.d.y"); 
       
        $vars = ["weather" => $weather];
        $vars["weatherIcon"] = $weatherIcon;
        $vars["temp"] = $temp;
        $vars["wind"]  = $wind;
        $vars["today"]  = $today;
        
        return $this->render('main/index.html.twig', $vars);
    }
}
