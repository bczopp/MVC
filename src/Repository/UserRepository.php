<?php
namespace Tornado\Repository;

use Tornado\Model\User;
use PDO;

class UserRepository extends Repository
{
    /**
     * @return string
     */
    protected function getEntityClass(): string
    {
        return User::class;
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'users';
    }

    /**
     * @return array|string
     */
    protected function getSelectedAttributes(): array|string
    {
        return ['id','username','email'];
    }
}
