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
            'message' => 'API Guide'
        ]);
    }
}
