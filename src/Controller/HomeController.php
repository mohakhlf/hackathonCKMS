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
    /**
     * Display home page
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
        $object1 = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/11324");
        $object2 = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/42493");
        $object3 = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/435905");
        $object4 = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/437980");

        $statusCode = $response->getStatusCode(); // get Response status code 200
        if ($statusCode === 200) {
            $content = $response->getContent();
            // get the response in JSON format

            $content = $response->toArray();
            $content1 = $object1->toArray();
            $content2 = $object2->toArray();
            $content3 = $object3->toArray();
            $content4 = $object4->toArray();
//            var_dump($content1);
//            var_dump($content2);
//            var_dump($content3);
//            var_dump($content4);
//            var_dump($content["objectIDs"]);
        }
        return $this->twig->render('Home/index.html.twig', ["content" => $content, "collection1"=>$content1, "collection2"=>$content2, "collection3"=>$content3, "collection4"=>$content4]);
    }
}
