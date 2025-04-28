<?php

namespace Tornado\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tornado\Model\User;

class UserTest extends TestCase
{
    public function testUser(): void
    {
        $id = 12;
        $username = 'otto';
        $email = 'ich@test.com';

        $user = new User($id, $username, $email);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());
    }
}