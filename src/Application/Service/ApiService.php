<?php

namespace App\Application\Service;


use App\Domain\Model\Group\Group;
use App\Domain\Model\Group\GroupRepositoryInterface;
use App\Domain\Model\User\User;
use App\Domain\Model\User\UserRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Class ApiService
 * @package App\Application\Service
 */
final class ApiService
{

    /**
     * @var userRepositoryInterface
     */
    private $userRepository;
    /**
     * @var groupRepositoryInterface
     */
    private $groupRepository;


    /**
     * ApiService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param GroupRepositoryInterface $groupRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, GroupRepositoryInterface $groupRepository) {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @param int $userId
     * @return User
     * @throws EntityNotFoundException
     */
    public function getUser(int $userId): User
    {
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new EntityNotFoundException('User with id '.$userId.' does not exist!');
        }
        return $user;
    }

    /**
     * @return array|null
     */
    public function getAllUsers(): ?array
    {
        return $this->userRepository->findAll();
    }


    /**
     * @param int $groupId
     * @return Group
     * @throws EntityNotFoundException
     */
    public function getGroup(int $groupId): Group
    {
        $group = $this->groupRepository->findById($groupId);
        if (!$group) {
            throw new EntityNotFoundException('Group with id '.$groupId.' does not exist!');
        }
        return $group;
    }

    /**
     * @return array|null
     */
    public function getAllGroups(): ?array
    {
        return $this->groupRepository->findAll();
    }


}
