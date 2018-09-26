<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;
use App\Entity\Service;

class ServiceController extends AbstractController
{
     /**
      * @Route("/services", name="service_list", methods={"GET"})
      */
     public function index()
     {
         $services = $this->get('doctrine')->getRepository(Service::class)->findAll();

         $json = array(
             'code'     => 200,
             'results'  => $services,
             'rowCount' => count($services)
         );

         $serializer = SerializerBuilder::create()->build();

         $jsonServices = $serializer->serialize($json, 'json');

         return new JsonResponse($jsonServices, 200, [], true);
     }

     /**
      * @Route("/services/{slug}", name="service_view", methods={"GET"})
      *
      */
     public function view($slug) {
         $services = $this->get('doctrine')->getRepository(Service::class)->findBySlug($slug);

         if (count($agencies) == 0) {
             // Create message if no agencies are found.
             $json = array('code' => '500', 'message' => 'No Service Found');

             return new JsonResponse($json);
         }


         $json = array(
             'code'     => 200,
             'results'  => $services
         );

         $serializer = SerializerBuilder::create()->build();

         $jsonServices = $serializer->serialize($json, 'json');

         return new JsonResponse($jsonServices, 200, [], true);
     }

}
