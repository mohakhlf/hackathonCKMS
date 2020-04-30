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

//    /**
//     * Display home page
//     *
//     * @return string
//     * @throws \Twig\Error\LoaderError
//     * @throws \Twig\Error\RuntimeError
//     * @throws \Twig\Error\SyntaxError
//     */
//    public function index()
//    {
//        $client = HttpClient::create();
//        $response = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/search?medium=Paintings&hasImages=true&q=sunset");
//        $object1 = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/437980");
//        $object2 = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/437980");
//        $object3 = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/437980");
//        $object4 = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/437980");
//
//
//        $statusCode = $response->getStatusCode(); // get Response status code 200
//
//        if ($statusCode === 200) {
//            $content = $response->getContent();
////             get the response in JSON format
//            $content = $response->toArray();
//            $content1 = $object1->toArray();
//            $content2 = $object2->toArray();
//            $content3 = $object3->toArray();
//            $content4 = $object4->toArray();
////             convert the response (here in JSON) to an PHP array
//            var_dump($content["objectIDs"]);
////            var_dump($content1);
////            var_dump($content2);
////            var_dump($content3);
////            var_dump($content4);
//        }
//
//
//        return $this->twig->render('Home/index.html.twig', ["content" => $content, "collection1"=>$content1, "collection2"=>$content2, "collection3"=>$content3, "collection4"=>$content4]);
//    }
//}

//    public function fetchByOne($code)
//    {
//        $client = HttpClient::create();
//        $objectM = $client->request("GET", "https://collectionapi.metmuseum.org/public/collection/v1/objects/$code");
//
//        $statusCodeM = $objectM->getStatusCode();
//
//        var_dump($statusCodeM);
//
//    }
//}
}

