<?php

namespace App\Test\Controller;

use App\Entity\Album;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/album/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Album::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Album index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'album[title]' => 'Testing',
            'album[releasedAt]' => 'Testing',
            'album[cover]' => 'Testing',
            'album[band]' => 'Testing',
            'album[users]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Album();
        $fixture->setTitle('My Title');
        $fixture->setReleasedAt('My Title');
        $fixture->setCover('My Title');
        $fixture->setBand('My Title');
        $fixture->setUsers('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Album');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Album();
        $fixture->setTitle('Value');
        $fixture->setReleasedAt('Value');
        $fixture->setCover('Value');
        $fixture->setBand('Value');
        $fixture->setUsers('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'album[title]' => 'Something New',
            'album[releasedAt]' => 'Something New',
            'album[cover]' => 'Something New',
            'album[band]' => 'Something New',
            'album[users]' => 'Something New',
        ]);

        self::assertResponseRedirects('/album/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getReleasedAt());
        self::assertSame('Something New', $fixture[0]->getCover());
        self::assertSame('Something New', $fixture[0]->getBand());
        self::assertSame('Something New', $fixture[0]->getUsers());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Album();
        $fixture->setTitle('Value');
        $fixture->setReleasedAt('Value');
        $fixture->setCover('Value');
        $fixture->setBand('Value');
        $fixture->setUsers('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/album/');
        self::assertSame(0, $this->repository->count([]));
    }
}
