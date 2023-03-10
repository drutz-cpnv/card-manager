<?php

namespace App\Test\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CardControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CardRepository $repository;
    private string $path = '/card/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Card::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Card index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'card[firstname]' => 'Testing',
            'card[lastname]' => 'Testing',
            'card[role]' => 'Testing',
            'card[rank]' => 'Testing',
            'card[number]' => 'Testing',
            'card[birthdate]' => 'Testing',
            'card[picture]' => 'Testing',
            'card[uid]' => 'Testing',
            'card[legal_text]' => 'Testing',
            'card[role_type]' => 'Testing',
            'card[to_print]' => 'Testing',
            'card[created_at]' => 'Testing',
            'card[updated_at]' => 'Testing',
            'card[rank_picture]' => 'Testing',
            'card[employee]' => 'Testing',
            'card[printRequest]' => 'Testing',
        ]);

        self::assertResponseRedirects('/card/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Card();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setRole('My Title');
        $fixture->setRank('My Title');
        $fixture->setNumber('My Title');
        $fixture->setBirthdate('My Title');
        $fixture->setPicture('My Title');
        $fixture->setUid('My Title');
        $fixture->setLegal_text('My Title');
        $fixture->setRole_type('My Title');
        $fixture->setTo_print('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setRank_picture('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setPrintRequest('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Card');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Card();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setRole('My Title');
        $fixture->setRank('My Title');
        $fixture->setNumber('My Title');
        $fixture->setBirthdate('My Title');
        $fixture->setPicture('My Title');
        $fixture->setUid('My Title');
        $fixture->setLegal_text('My Title');
        $fixture->setRole_type('My Title');
        $fixture->setTo_print('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setRank_picture('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setPrintRequest('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'card[firstname]' => 'Something New',
            'card[lastname]' => 'Something New',
            'card[role]' => 'Something New',
            'card[rank]' => 'Something New',
            'card[number]' => 'Something New',
            'card[birthdate]' => 'Something New',
            'card[picture]' => 'Something New',
            'card[uid]' => 'Something New',
            'card[legal_text]' => 'Something New',
            'card[role_type]' => 'Something New',
            'card[to_print]' => 'Something New',
            'card[created_at]' => 'Something New',
            'card[updated_at]' => 'Something New',
            'card[rank_picture]' => 'Something New',
            'card[employee]' => 'Something New',
            'card[printRequest]' => 'Something New',
        ]);

        self::assertResponseRedirects('/card/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFirstname());
        self::assertSame('Something New', $fixture[0]->getLastname());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getRank());
        self::assertSame('Something New', $fixture[0]->getNumber());
        self::assertSame('Something New', $fixture[0]->getBirthdate());
        self::assertSame('Something New', $fixture[0]->getPicture());
        self::assertSame('Something New', $fixture[0]->getUid());
        self::assertSame('Something New', $fixture[0]->getLegal_text());
        self::assertSame('Something New', $fixture[0]->getRole_type());
        self::assertSame('Something New', $fixture[0]->getTo_print());
        self::assertSame('Something New', $fixture[0]->getCreated_at());
        self::assertSame('Something New', $fixture[0]->getUpdated_at());
        self::assertSame('Something New', $fixture[0]->getRank_picture());
        self::assertSame('Something New', $fixture[0]->getEmployee());
        self::assertSame('Something New', $fixture[0]->getPrintRequest());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Card();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setRole('My Title');
        $fixture->setRank('My Title');
        $fixture->setNumber('My Title');
        $fixture->setBirthdate('My Title');
        $fixture->setPicture('My Title');
        $fixture->setUid('My Title');
        $fixture->setLegal_text('My Title');
        $fixture->setRole_type('My Title');
        $fixture->setTo_print('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setRank_picture('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setPrintRequest('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/card/');
    }
}
