<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use JMS\Serializer\SerializerBuilder;
use App\Entity\Agency;

class AgencyController extends AbstractController
{

    /**
     * @Route("/agencies", name="agency_list", methods={"GET"})
     */
    public function index()
    {
        $em = $this->get('doctrine')->getManager();
        $serializer = SerializerBuilder::create()->build();

        // Get all agencies.
        $agencies = $this->get('doctrine')->getRepository(Agency::class)->findAll();

        // Create json data
        $json = array(
            'code'     => 200,
            'results'  => $agencies,
            'rowCount' => count($agencies)
        );

        // Convert to json format.
        $jsonAgencies = $serializer->serialize($json, 'json');

        // Create json reponse with raw json.
        return new JsonResponse($jsonAgencies, 200, [], true);
    }

    /**
     * @Route("/agencies/{id}", name="agency_view", methods={"GET"})
     */
    public function view($id) {
        $serializer = SerializerBuilder::create()->build();

        // Find agency with id.
        $agencies = $this->get('doctrine')->getRepository(Agency::class)->findById($id);

        if (count($agencies) == 0) {
            // Create message if no agencies are found.
            $json = array('code' => '500', 'message' => 'No Agencies Found');

            return new JsonResponse($json);
        }

        // Convert to json format
        $jsonAgencies = $serializer->serialize($agencies, 'json');

        // Create json reponse with raw json
        return new JsonResponse($jsonAgencies, 200, [], true);
    }

    /**
     * @Route("/agencies", name="agency_create", methods={"POST"})
     */
    public function create(Request $input, ValidatorInterface $validator) {

        $agencyEntity = new Agency();

        $requiredFields = array(
            'agency_name',
            'contact_email',
            'web_address',
            'short_description',
            'established'
        );

        $postData = $input->request->all();

        // Check required fields
        foreach ($requiredFields as $field) {
            if (!isset($postData[$field])) {
                return new JsonResponse(['code' => 500, 'message' => 'Please check all required fields have been sent']);
            }
        }

        // Set Agency Entity Variables
        $agencyEntity->setAgencyName($input->request->get('agency_name'));
        $agencyEntity->setContactEmail($input->request->get('contact_email'));
        $agencyEntity->setWebAddress($input->request->get('web_address'));
        $agencyEntity->setShortDescription($input->request->get('short_description'));
        $agencyEntity->setEstablished($input->request->get('established'));

        $errors    = $validator->validate($agencyEntity);

        // Validate all input using symfony validator
        if (count($errors) > 0) {
            $error = array();

            foreach ($errors as $violation) {
                array_push($error, array('field' => $violation->getPropertyPath(), 'message' => $violation->getMessage()));
            }

            return new JsonResponse(['code' => 500, 'message' => $error]);
        }

        $em = $this->get('doctrine')->getManager();

        try {
            $em->persist($agencyEntity);
            $em->flush();
        } catch(\Exception $e) {
            echo 'error message: ' . $e->getMessage();
        }

        return new JsonResponse(['code' => 200, 'message' => 'New Agency Created Successfully']);
    }

}
