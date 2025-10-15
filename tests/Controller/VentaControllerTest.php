<?php

namespace App\Tests\Controller;

use App\Entity\Venta;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class VentaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $ventumRepository;
    private string $path = '/venta/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->ventumRepository = $this->manager->getRepository(Venta::class);

        foreach ($this->ventumRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ventum index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'ventum[fecha]' => 'Testing',
            'ventum[total]' => 'Testing',
            'ventum[estado]' => 'Testing',
            'ventum[formaPago]' => 'Testing',
            'ventum[observacion]' => 'Testing',
            'ventum[createdAt]' => 'Testing',
            'ventum[updatedAt]' => 'Testing',
            'ventum[cliente]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->ventumRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Venta();
        $fixture->setFecha('My Title');
        $fixture->setTotal('My Title');
        $fixture->setEstado('My Title');
        $fixture->setFormaPago('My Title');
        $fixture->setObservacion('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setCliente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ventum');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Venta();
        $fixture->setFecha('Value');
        $fixture->setTotal('Value');
        $fixture->setEstado('Value');
        $fixture->setFormaPago('Value');
        $fixture->setObservacion('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setCliente('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'ventum[fecha]' => 'Something New',
            'ventum[total]' => 'Something New',
            'ventum[estado]' => 'Something New',
            'ventum[formaPago]' => 'Something New',
            'ventum[observacion]' => 'Something New',
            'ventum[createdAt]' => 'Something New',
            'ventum[updatedAt]' => 'Something New',
            'ventum[cliente]' => 'Something New',
        ]);

        self::assertResponseRedirects('/venta/');

        $fixture = $this->ventumRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getFecha());
        self::assertSame('Something New', $fixture[0]->getTotal());
        self::assertSame('Something New', $fixture[0]->getEstado());
        self::assertSame('Something New', $fixture[0]->getFormaPago());
        self::assertSame('Something New', $fixture[0]->getObservacion());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getCliente());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Venta();
        $fixture->setFecha('Value');
        $fixture->setTotal('Value');
        $fixture->setEstado('Value');
        $fixture->setFormaPago('Value');
        $fixture->setObservacion('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setCliente('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/venta/');
        self::assertSame(0, $this->ventumRepository->count([]));
    }
}
