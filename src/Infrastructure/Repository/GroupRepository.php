<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Group\Group;
use App\Domain\Model\Group\GroupRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class GroupRepository
 * @package App\Infrastructure\Repository
 */
final class GroupRepository implements GroupRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    /**
     * GroupRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Group::class);
    }

    /**
     * @param int $groupId
     * @return Group
     */
    public function findById(int $groupId): ?Group
    {
        return $this->objectRepository->find($groupId);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }

    /**
     * @param Group $group
     */
    public function save(Group $group): void
    {
        $this->entityManager->persist($group);
        $this->entityManager->flush();
    }

    /**
     * @param Group $group
     */
    public function delete(Group $group): void
    {
        $this->entityManager->remove($group);
        $this->entityManager->flush();
    }

}
