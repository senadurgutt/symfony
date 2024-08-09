<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testCategoryIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/category/index');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Category List');
    }

// Diğer test metodlarını buraya ekleyebilirsiniz
}
