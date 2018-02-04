<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use ZeroConfig\Cli\Transformer\TransformerChain;
use ZeroConfig\Cli\Transformer\TransformerInterface;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\TransformerChain
 */
class TransformerChainTest extends TestCase
{
    /**
     * @return void
     * @covers ::__invoke
     */
    public function testInvoke(): void
    {
        /** @var TransformerInterface|PHPUnit_Framework_MockObject_MockObject $transformer */
        $transformer = $this->createMock(TransformerInterface::class);
        $chain       = new TransformerChain(
            $transformer,
            $transformer,
            $transformer
        );

        $transformer
            ->expects(self::exactly(3))
            ->method('__invoke')
            ->with(self::isType('array'))
            ->willReturnCallback(
                function (array $input): array {
                    [$number] = $input;
                    return [$number * 2];
                }
            );

        // 2 × 2³ = 16
        $this->assertEquals([16], $chain([2]));
    }
}
