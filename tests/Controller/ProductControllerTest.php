<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProductIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/product/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ürün Listesi');
        $this->assertSelectorTextContains('.box-title', 'Bordered Table');
    }

    public function testProductNew()
    {
        $client = static::createClient();

        // "New Product" sayfasını yükleme testi
        $crawler = $client->request('GET', '/admin/product/new');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Yeni Ürün');

        // Formun doğru şekilde render edildiğini test etme
        $form = $crawler->selectButton('Save')->form([
            'product[title]' => 'New Product',
            'product[description]' => 'This is a new product',
            'product[category]' => 1,
            'product[member]' => 1,
            // 'product[image]' => 'path/to/image.jpg', // Eğer bir image eklemeniz gerekiyorsa
        ]);

        // Formu gönderme
        $client->submit($form);

        // Formun başarılı bir şekilde gönderilip gönderilmediğini kontrol etme
        $this->assertResponseRedirects('/admin/product/index');

        // Yönlendirme sonrası sayfayı takip etme
        $client->followRedirect();

        // Yeni ürünün listeye eklendiğini kontrol etme
        $this->assertSelectorTextContains('.table', 'New Product');
    }


}
