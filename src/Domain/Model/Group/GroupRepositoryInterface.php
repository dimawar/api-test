<?php

namespace App\Domain\Model\Group;

/**
 * Interface GroupRepositoryInterface
 * @package App\Domain\Model\Group
 */
interface GroupRepositoryInterface
{

    /**
     * @param int $groupId
     * @return Group
     */
    public function findById(int $groupId): ?Group;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param Group $group
     */
    public function save(Group $group): void;

    /**
     * @param Group $group
     */
    public function delete(Group $group): void;

}
