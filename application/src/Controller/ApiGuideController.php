<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiGuideController extends AbstractController
{
    /**
     * @Route("/", name="api_guide")
     */
    public function index()
    {
        return $this->json([
            'message'       => 'API Guide',
            'possible-urls' => array(
                0 =>  array(
                    'url' => 'http://127.0.0.1:8009/agencies',
                    'method' => 'GET'
                ),
                1 => array(
                    'url' => 'http://127.0.0.1:8009/agencies/{id}',
                    'method' => 'GET'
                ),
                2 => array(
                    'url' => 'http://127.0.0.1:8009/agencies',
                    'method' => 'POST',
                    'post-fields' => array(
                        'agency_name',
                        'contact_email',
                        'web_address',
                        'short_description',
                        'established'
                    )
                ),
                3 => array(
                    'url' => 'http://127.0.0.1:8009/services',
                    'method' => 'GET'
                ),
                4 => array(
                    'url' => 'http://127.0.0.1:8009/services/{slug}',
                    'method' => 'GET'
                ),
                5 => array(
                    'url' => 'http://127.0.0.1:8009/agencyservices/{id}',
                    'method' => 'GET'
                ),
                6 => array(
                    'url' => 'http://127.0.0.1:8009/agencyservices/{id}',
                    'method' => 'POST',
                    'post-fields' => array(
                        'service_slug'
                    )
                )


            )

        ]);
    }
}
