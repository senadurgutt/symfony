<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MemberControllerTest extends WebTestCase
{
    public function testMemberIndex()
    {
        // Web client oluştur
        $client = static::createClient();

        // "/admin/member/index" sayfasına GET isteği gönder
        $crawler = $client->request('GET', '/admin/member/index');

        // Sayfanın başarılı bir şekilde yüklendiğini doğrula
        $this->assertResponseIsSuccessful();

        // Sayfada "Kullanıcı Listesi" başlığının bulunup bulunmadığını kontrol et
        $this->assertSelectorTextContains('h1', 'Kullanıcı Listesi');

        // Tablo başlıklarını ve verilerini kontrol et
        $this->assertSelectorTextContains('table > tr > th:nth-child(1)', 'id');
        $this->assertSelectorTextContains('table > tr > th:nth-child(2)', 'İsim');
        $this->assertSelectorTextContains('table > tr > th:nth-child(3)', 'Soyisim');
        $this->assertSelectorTextContains('table > tr > th:nth-child(4)', 'Email');
        $this->assertSelectorTextContains('table > tr > th:nth-child(5)', 'Password');
        $this->assertSelectorTextContains('table > tr > th:nth-child(6)', 'Sil');

        // Varsayılan olarak, üyelerin listelendiğini doğrula
        $this->assertGreaterThan(0, $crawler->filter('tr')->count(), 'No members found');
    }

//    public function testLoginPage()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/login');
//
//        // Sayfa çıktısını kontrol et
//        // echo $crawler->html(); // Debug amacıyla kullanılabilir
//
//        // Form elemanlarının varlığını kontrol et
//        $this->assertSelectorExists('input[name="login_form[email]"]');
//        $this->assertSelectorExists('input[name="login_form[password]"]');
//        $this->assertSelectorTextContains('button[type="submit"]', 'Giriş Yap');
//
//        // Kayıt Ol butonunun varlığını ve doğru rotaya yönlendirme yapıp yapmadığını kontrol et
//        $this->assertSelectorExists('a[href="' . $client->getContainer()->get('router')->generate('member_form') . '"]');
//        $this->assertSelectorTextContains('a', 'Kayıt Ol');
//// Debug için form alanlarının nasıl alındığını kontrol edin
//        $formData = $client->getRequest()->request->all();
//        var_dump($formData);
//
//        // Form gönderimi ile geçerli kullanıcı girişini simüle et
//        $form = $crawler->selectButton('Giriş Yap')->form([
//            'login_form[email]' => 'ceku@kedi.com',
//            'login_form[password]' => 'ceku',
//        ]);
//
//        $client->submit($form);
//
//        // Giriş sonrası yönlendirmenin başarılı olup olmadığını kontrol et
//        $this->assertResponseRedirects('/home');
//        // Yönlendirme sonrasında hedef sayfanın açıldığını doğrula
//        $client->followRedirect();
//    }


    public function testLoginPageForGuest()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // Sayfa çıktısını kontrol et
        // echo $crawler->html(); // Debug amacıyla kullanılabilir

        // Form elemanlarının varlığını kontrol et
        $this->assertSelectorExists('input[name="login_form[email]"]');
        $this->assertSelectorExists('input[name="login_form[password]"]');
        $this->assertSelectorTextContains('button[type="submit"]', 'Giriş Yap');

        // Kayıt Ol butonunun varlığını ve doğru rotaya yönlendirme yapıp yapmadığını kontrol et
        $this->assertSelectorExists('a[href="' . $client->getContainer()->get('router')->generate('member_form') . '"]');
        $this->assertSelectorTextContains('a', 'Kayıt Ol');
    }


}

