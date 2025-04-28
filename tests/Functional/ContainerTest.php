<?php

namespace Tornado\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Tornado\Service\Container;

class ContainerTest extends TestCase
{
    public function testContainer(): void
    {
        $definition = function(Container $container) {
            $container->set(\stdClass::class, function($container) {
                return new \stdClass();
            });
        };
        $container = new Container([$definition]);

        # get
        $fromContainer = $container->get(\stdClass::class);
        $this->assertInstanceof(\stdClass::class, $fromContainer);

        # get with exception
        $this->expectException(\Exception::class);
        $container->get('undefined');
    }

}
