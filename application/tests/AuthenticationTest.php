<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticationTest extends WebTestCase
{
    /*
        Api Token
            Authentication Required
            Authentication Granted

     */

    protected $baseurl   = 'http://127.0.0.1:8009/';
    protected $api_token = '946bdc1a-f91c-497b-b4a8-b3b35b2242c8';

    public function testAuthenticationTokenFailed() {
        $client = static::createClient(array(), array('HTTP_X_AUTH_TOKEN' => 'wrongapikey'));

        $client->request('GET', $this->baseurl, array(), array(), array());

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals("Authentication Required", $content->message);
    }

    public function testAuthenticationTokenSuccess() {
        $client = static::createClient();

        $client->request('GET', $this->baseurl, array(), array(), array('HTTP_X_AUTH_TOKEN' => $this->api_token));

        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals("API Guide", $content->message);
    }
}
