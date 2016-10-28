<?php

namespace HotelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testReservationlist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/lista-rezerwacji');
    }

}
