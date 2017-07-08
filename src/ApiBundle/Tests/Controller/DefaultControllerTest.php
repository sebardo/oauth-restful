<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testError()
    {
        $data = array(
                //'email' => 'sebas@email.com',
                'name' => 'Sastu',
        );
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/users/new', $data);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('status', json_decode($client->getResponse()->getContent(), true));
        $this->assertArrayHasKey('error', json_decode($client->getResponse()->getContent(), true));
        
    }
    
    public function testSuccess()
    {
        $uid = uniqid();
        $data = array(
                'email' => $uid . '@email.com',
                'name' => 'Sastu',
                'password' => $uid,
        );
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/users/new', $data);

        $return = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $this->assertEquals('success', $return['status']);
        
    }
}
