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

    public function testLoginPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // Sayfanın açılıp açılmadığını kontrol et
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Giriş Yap');

        // Email input alanını kontrol et
        $this->assertSelectorExists('input[name="email"]');
        $this->assertSelectorExists('input[type="email"]');

        // Şifre input alanını kontrol et
        $this->assertSelectorExists('input[name="password"]');
        $this->assertSelectorExists('input[type="password"]');

        // Kayıt Ol butonunun varlığını ve doğru rotaya yönlendirme yapıp yapmadığını kontrol et
        $this->assertSelectorExists('a[href="' . $this->getContainer()->get('router')->generate('member_form') . '"]');
        $this->assertSelectorTextContains('a', 'Kayıt Ol');

        // Form gönderimi ile geçerli kullanıcı girişini simüle et
        $form = $crawler->selectButton('Giriş Yap')->form([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $client->submit($form);

        // Giriş sonrası yönlendirmenin başarılı olup olmadığını kontrol et
        $this->assertResponseRedirects('/home');

        // Yönlendirme sonrasında hedef sayfanın açıldığını doğrula
        $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hoş Geldiniz');
    }}
