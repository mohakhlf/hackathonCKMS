<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
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

    /**
     * @param $code
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function View($code)
    {
        $url = "https://collectionapi.metmuseum.org/public/collection/v1/objects/" . $code;
        $data = file_get_contents($url);
        $decode = json_decode($data);
        $produit = [
            'title' => $decode->title,
            'image' => $decode->primaryImage,
            'bomArtiste' => $decode -> artistDisplayName
        ];
        return $this->twig->render('Home/View.html.twig', ["produit"=>$produit]);
    }
}
