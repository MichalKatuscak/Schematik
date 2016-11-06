<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testIndexIsSuccessful()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', "/");

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Spuštění hry")')->count()
        );
    }


    /**
     * @dataProvider urlPostProvider
     */
    public function testPagePostIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isRedirect("/"));
    }

    public function urlPostProvider()
    {
        return [
            ['/zacatek'],
            ['/konec']
        ];
    }

    public function urlProvider()
    {
        return [
            ['/']
        ];
    }
}