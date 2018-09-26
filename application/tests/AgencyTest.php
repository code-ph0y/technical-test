<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AgencyTest extends WebTestCase
{
    /*
        Agencies

        Retrieve an index of agencies
        View details of single agency by retrieving it by its ID
        Create a new agency
     */

    protected $baseurl = 'http://127.0.0.1:8009/';
    protected $api_token = '946bdc1a-f91c-497b-b4a8-b3b35b2242c8';

    public function testAgencyIndexResponse()
    {
        $client = static::createClient();

        $client->request('GET', $this->baseurl . 'agencies', array(), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAgencyIndexContentTypeHasJson()
    {
        $client = static::createClient();

        $client->request('GET', $this->baseurl . 'agencies');

        $this->assertTrue(
        $client->getResponse()->headers->contains(
            'Content-Type',
            'application/json'
        ));
    }

    public function testAgencyViewResponse()
    {
        $client = static::createClient();

        $client->request('GET', $this->baseurl . 'agencies/17', array(), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAgencyViewAgencyNotFound()
    {
        $client = static::createClient();

        $client->request('GET', $this->baseurl . 'agencies/-1', array(), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(500, $content->code);
    }

    public function testAgencyCreateNewAgencySuccess()
    {
        $client = static::createClient();

        $postData = array(
            'agency_name'       => 'Test Agency',
            'contact_email'     => 'test@testagency.com',
            'web_address'       => 'https://www.thedrum.com/',
            'short_description' => 'This is a Test Agency',
            'established'       => '2018'
        );

        $client->request('POST', $this->baseurl . 'agencies', $postData, array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $content->code);
    }

    public function testAgencyCreateNewAgencyErrors()
    {
        $client = static::createClient();

        $postData = array(
            'agency_name'       => '',
            'contact_email'     => '',
            'web_address'       => '',
            'short_description' => '',
            'established'       => ''
        );

        $client->request('POST', $this->baseurl . 'agencies', $postData, array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(500, $content->code);
    }

    public function testAgencyCreateNewWithNoPostData()
    {
        $client = static::createClient();

        $postData = array(

        );

        $client->request('POST', $this->baseurl . 'agencies', $postData, array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(500, $content->code);
    }

}
