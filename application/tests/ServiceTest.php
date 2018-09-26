<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServiceTest extends WebTestCase
{
    /*
    Services
        Retrieve an index of services
        View details of a single service by retrieving it by its slug

    */

    protected $baseurl   = 'http://127.0.0.1:8009/';
    protected $api_token = '946bdc1a-f91c-497b-b4a8-b3b35b2242c8';

    public function testServiceIndexAllServices()
    {
        $client = static::createClient();

        $client->request('GET', $this->baseurl . 'services', array(), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $content->code);
    }

    public function testServiceViewUsingSlug()
    {
        $client = static::createClient();

        $client->request('GET', $this->baseurl . 'services', array(), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $content->code);
    }

}
