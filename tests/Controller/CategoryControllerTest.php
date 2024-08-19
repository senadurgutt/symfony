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
        $this->assertSelectorTextContains('h1',  'Kategori Listesi');
    }

    public function testCategoryNew()
    {
        $client = static::createClient();

        // "New Category" sayfasını yükleme testi
        $crawler = $client->request('GET', '/admin/category/new');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Kullanıcı Listesi Kullanıcı ekle');

        // Formun doğru şekilde render edildiğini test etme
        $form = $crawler->selectButton('Save')->form([
            'category[parentId]' => 1,
            'category[title]' => 'New Category',
            'category[description]' => 'This is a new category',
            'category[category]' => 2,
        ]);

        // Formu gönderme
        $client->submit($form);

        // Formun başarılı bir şekilde gönderilip gönderilmediğini kontrol etme
        $this->assertResponseRedirects('/admin/category/index');

        // Yönlendirme sonrası sayfayı takip etme
        $client->followRedirect();

        // Yeni kategorinin listeye eklendiğini kontrol etme
        $this->assertSelectorTextContains('.box-title', 'Bordered Table');
    }

// Diğer test metodlar buraya
}
