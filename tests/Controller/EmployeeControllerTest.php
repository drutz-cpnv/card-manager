<?php

namespace App\Test\Controller;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EmployeeRepository $repository;
    private string $path = '/employee/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Employee::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Employee index');

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
            'employee[firstname]' => 'Testing',
            'employee[lastname]' => 'Testing',
            'employee[badge_number]' => 'Testing',
            'employee[birthdate]' => 'Testing',
            'employee[phone_number]' => 'Testing',
            'employee[email]' => 'Testing',
            'employee[isPolice]' => 'Testing',
            'employee[picture]' => 'Testing',
            'employee[created_at]' => 'Testing',
            'employee[updated_at]' => 'Testing',
            'employee[gender]' => 'Testing',
            'employee[role]' => 'Testing',
            'employee[rank]' => 'Testing',
        ]);

        self::assertResponseRedirects('/employee/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Employee();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setBadge_number('My Title');
        $fixture->setBirthdate('My Title');
        $fixture->setPhone_number('My Title');
        $fixture->setEmail('My Title');
        $fixture->setIsPolice('My Title');
        $fixture->setPicture('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setGender('My Title');
        $fixture->setRole('My Title');
        $fixture->setRank('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Employee');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Employee();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setBadge_number('My Title');
        $fixture->setBirthdate('My Title');
        $fixture->setPhone_number('My Title');
        $fixture->setEmail('My Title');
        $fixture->setIsPolice('My Title');
        $fixture->setPicture('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setGender('My Title');
        $fixture->setRole('My Title');
        $fixture->setRank('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'employee[firstname]' => 'Something New',
            'employee[lastname]' => 'Something New',
            'employee[badge_number]' => 'Something New',
            'employee[birthdate]' => 'Something New',
            'employee[phone_number]' => 'Something New',
            'employee[email]' => 'Something New',
            'employee[isPolice]' => 'Something New',
            'employee[picture]' => 'Something New',
            'employee[created_at]' => 'Something New',
            'employee[updated_at]' => 'Something New',
            'employee[gender]' => 'Something New',
            'employee[role]' => 'Something New',
            'employee[rank]' => 'Something New',
        ]);

        self::assertResponseRedirects('/employee/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFirstname());
        self::assertSame('Something New', $fixture[0]->getLastname());
        self::assertSame('Something New', $fixture[0]->getBadge_number());
        self::assertSame('Something New', $fixture[0]->getBirthdate());
        self::assertSame('Something New', $fixture[0]->getPhone_number());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getIsPolice());
        self::assertSame('Something New', $fixture[0]->getPicture());
        self::assertSame('Something New', $fixture[0]->getCreated_at());
        self::assertSame('Something New', $fixture[0]->getUpdated_at());
        self::assertSame('Something New', $fixture[0]->getGender());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getRank());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Employee();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setBadge_number('My Title');
        $fixture->setBirthdate('My Title');
        $fixture->setPhone_number('My Title');
        $fixture->setEmail('My Title');
        $fixture->setIsPolice('My Title');
        $fixture->setPicture('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setGender('My Title');
        $fixture->setRole('My Title');
        $fixture->setRank('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/employee/');
    }
}
