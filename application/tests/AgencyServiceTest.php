<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AgencyServiceTest extends WebTestCase
{
    /*
        Relationships
            View the services an agency offers
            Update the services an agency offers
     */

    protected $baseurl   = 'http://127.0.0.1:8009/';
    protected $api_token = '946bdc1a-f91c-497b-b4a8-b3b35b2242c8';

    public function testAgencyServiceViewAllById()
    {
        $client = static::createClient();

        $client->request('GET', $this->baseurl . 'agencies', array(), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $agencies = json_decode($client->getResponse()->getContent());

        $firstId = $agencies->results[0]->id;

        $client->request('GET', $this->baseurl . 'agencyservices/' . $firstId, array(), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $content->code);
    }

    public function testAgencyServiceAddServiceToAgency()
    {
        $client = static::createClient();

        $client->request('GET', $this->baseurl . 'agencies', array(), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $agencies = json_decode($client->getResponse()->getContent());

        $firstId = $agencies->results[0]->id;

        $client->request('POST', $this->baseurl . 'agencyservices/' . $firstId, array('service_slug' => 'seo'), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals('New Service Added Successfully', $content->message);
    }
}
