<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerBuilder;
use App\Entity\Agency;
use App\Entity\Service;

class AgencyServiceController extends AbstractController
{
    /**
     * @Route("/agencyservices/{id}", name="agency_services_view", methods={"GET"})
     */
    public function view($id)
    {
        $em = $this->get('doctrine')->getManager();
        $services = $this->get('doctrine')->getRepository(Service::class)->findAll();

        $serializer = SerializerBuilder::create()->build();

        $agencyRepository = $em->getRepository(Agency::class);

        $agency = $agencyRepository->find($id);

        $services = $agency->getServices();

        $json = array(
            'code'     => 200,
            'results'  => $services,
            'rowCount' => count($services)
        );

        $jsonServices = $serializer->serialize($json, 'json');

        // Create json reponse with raw json.
        return new JsonResponse($jsonServices, 200, [], true);
    }

    /**
     * @Route("/agencyservices/{id}", name="agency_services_update", methods={"POST"})
     */
    public function update(Request $input, ValidatorInterface $validator, $id)
    {

        $requiredFields = array(
            'service_slug'
        );

        $postData = $input->request->all();

        // Check required fields
        foreach ($requiredFields as $field) {
            if (!isset($postData[$field])) {
                return new JsonResponse(['code' => 500, 'message' => 'Please check all required fields have been sent']);
            }
        }

        $em = $this->get('doctrine')->getManager();

        $agencyRepository  = $em->getRepository(Agency::class);
        $serviceRepository = $em->getRepository(Service::class);

        $agencyEntity  = $agencyRepository->findOneById($id);

        $serviceEntity = $serviceRepository->findOneBySlug($input->request->get('service_slug'));

        $agencyEntity->addService($serviceEntity);

        try {
            $em->persist($agencyEntity);
            $em->flush();
        } catch(\Exception $e) {
            return new JsonResponse(['code' => 500, 'message' => $e->getMessage()]);
        }

        return new JsonResponse(['code' => 200, 'message' => 'New Service Added Successfully']);
    }


}
