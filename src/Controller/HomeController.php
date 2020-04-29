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
        $response = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/search?medium=Paintings&hasImages=true&q=sunset");
        $object = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/53660");

        $statusCode = $response->getStatusCode(); // get Response status code 200

        if ($statusCode === 200) {
            $content = $response->getContent();
            // get the response in JSON format

            $content = $response->toArray();
            $content1 = $object->toArray();
            // convert the response (here in JSON) to an PHP array
//            var_dump($content);
//            var_dump($content1);
        }

        return $this->twig->render('Home/index.html.twig', ["collection"=>$content, "collection1"=>$content1]);
    }
}
