<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;
use Symfony\Component\HttpClient\HttpClient;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $client = HttpClient::create();
        $response = $client->request("GET", "https://api.windy.com/api/webcams/v2/list/country=FR?key=zstN1Wb3W5GWTdmXMHvyScEs7TXJdpWL");

        $statusCode = $response->getStatusCode(); // get Response status code 200
        if ($statusCode === 200) {
            $content = $response->getContent();
            // get the response in JSON format
        
            $content = $response->toArray();
            // convert the response (here in JSON) to an PHP array
        }

        return $this->twig->render('Home/index.html.twig', ["webcams" => $content["result"]["webcams"]]);
    }
}