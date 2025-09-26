<?php

namespace App\Tests\Controller;

use App\Entity\Cliente;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ClienteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $clienteRepository;
    private string $path = '/cliente/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->clienteRepository = $this->manager->getRepository(Cliente::class);

        foreach ($this->clienteRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cliente index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'cliente[nombre]' => 'Testing',
            'cliente[apellido]' => 'Testing',
            'cliente[correo]' => 'Testing',
            'cliente[telefono]' => 'Testing',
            'cliente[celular]' => 'Testing',
            'cliente[domicilio]' => 'Testing',
            'cliente[localidad]' => 'Testing',
            'cliente[negocio]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->clienteRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cliente();
        $fixture->setNombre('My Title');
        $fixture->setApellido('My Title');
        $fixture->setCorreo('My Title');
        $fixture->setTelefono('My Title');
        $fixture->setCelular('My Title');
        $fixture->setDomicilio('My Title');
        $fixture->setLocalidad('My Title');
        $fixture->setNegocio('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cliente');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cliente();
        $fixture->setNombre('Value');
        $fixture->setApellido('Value');
        $fixture->setCorreo('Value');
        $fixture->setTelefono('Value');
        $fixture->setCelular('Value');
        $fixture->setDomicilio('Value');
        $fixture->setLocalidad('Value');
        $fixture->setNegocio('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'cliente[nombre]' => 'Something New',
            'cliente[apellido]' => 'Something New',
            'cliente[correo]' => 'Something New',
            'cliente[telefono]' => 'Something New',
            'cliente[celular]' => 'Something New',
            'cliente[domicilio]' => 'Something New',
            'cliente[localidad]' => 'Something New',
            'cliente[negocio]' => 'Something New',
        ]);

        self::assertResponseRedirects('/cliente/');

        $fixture = $this->clienteRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getApellido());
        self::assertSame('Something New', $fixture[0]->getCorreo());
        self::assertSame('Something New', $fixture[0]->getTelefono());
        self::assertSame('Something New', $fixture[0]->getCelular());
        self::assertSame('Something New', $fixture[0]->getDomicilio());
        self::assertSame('Something New', $fixture[0]->getLocalidad());
        self::assertSame('Something New', $fixture[0]->getNegocio());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cliente();
        $fixture->setNombre('Value');
        $fixture->setApellido('Value');
        $fixture->setCorreo('Value');
        $fixture->setTelefono('Value');
        $fixture->setCelular('Value');
        $fixture->setDomicilio('Value');
        $fixture->setLocalidad('Value');
        $fixture->setNegocio('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/cliente/');
        self::assertSame(0, $this->clienteRepository->count([]));
    }
}
