<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mockery as m;
use DoctrineSortableCollections\Comparer\Comparer;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Class ComparerTest.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class ComparerTest extends PHPUnit_Framework_TestCase
{
    protected $comparerFQN = 'DoctrineSortableCollections\Comparer\Comparer';

    protected function tearDown()
    {
        m::close();
    }

    /**
     * @return Comparer
     */
    protected function getComparer()
    {
        return $this->getMockForAbstractClass('DoctrineSortableCollections\Comparer\Comparer');
    }

    public function testConstruct()
    {
        $c = $this->getComparer();

        $this->assertSame(Comparer::ASC, $c->getDirection());
        $this->assertNull($c->getPropertyAccessor());
        $this->assertNull($c->getPropertyPath());
    }

    public function testSetAndGetDirection()
    {
        $c = $this->getComparer();

        $result = $c->setDirection(Comparer::DESC);
        $this->assertInstanceOf($this->comparerFQN, $result);

        $result = $c->getDirection();
        $this->assertSame(Comparer::DESC, $result);

        $this->setExpectedException('InvalidArgumentException');
        $c->setDirection('Invalid Value');
    }

    public function testIsAscAndIsDesc()
    {
        $c = $this->getComparer();

        $result = $c->isAsc();
        $this->assertTrue($result);

        $result = $c->isDesc();
        $this->assertFalse($result);

        $c->setDirection(Comparer::DESC);
        $result = $c->isDesc();
        $this->assertTrue($result);
    }

    public function testSetAndGetPropertyAccessor()
    {
        $c = $this->getComparer();
        $m = m::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface');

        $result = $c->setPropertyAccessor(null);
        $this->assertInstanceOf($this->comparerFQN, $result);

        $result = $c->getPropertyAccessor();
        $this->assertNull($result);

        $c->setPropertyAccessor($m);
        $this->assertInstanceOf(
            'Symfony\Component\PropertyAccess\PropertyAccessorInterface',
            $c->getPropertyAccessor()
        );

        $this->setExpectedException('InvalidArgumentException');
        $c->setPropertyAccessor('Invalid Value');
    }

    public function testSetAndGetPropertyPath()
    {
        $c    = $this->getComparer();
        $path = m::mock('Symfony\Component\PropertyAccess\PropertyPathInterface');

        $result = $c->setPropertyPath($path);
        $this->assertInstanceOf($this->comparerFQN, $result);

        $result = $c->getPropertyPath();
        $this->assertInstanceOf('Symfony\Component\PropertyAccess\PropertyPathInterface', $result);

        $result = $c->setPropertyPath(null);
        $this->assertInstanceOf($this->comparerFQN, $result);

        $result = $c->getPropertyPath();
        $this->assertNull($result);

        $this->setExpectedException('InvalidArgumentException');
        $c->setPropertyPath('Invalid Value');
    }

    /**
     * @depends testSetAndGetPropertyPath
     */
    public function testHasPropertyPath()
    {
        $c    = $this->getComparer();
        $path = m::mock('Symfony\Component\PropertyAccess\PropertyPathInterface');

        $result = $c->hasPropertyPath();
        $this->assertFalse($result);

        $c->setPropertyPath($path);
        $result = $c->hasPropertyPath();
        $this->assertTrue($result);
    }

    public function testGetComperarOperandSameAsOriginalElement()
    {
        $c = $this->getComparer();
        $c->setPropertyAccessor(null);
        $c->setPropertyPath(null);

        $result = $c->getComparerOperand('element');
        $this->assertSame('element', $result);
    }

    public function testGetComparerOperandSettingOnlyPropertyAccessor()
    {
        $c = $this->getComparer();
        $a = m::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface');
        $c->setPropertyAccessor($a);

        $result = $c->getComparerOperand('element');
        $this->assertSame('element', $result);
    }

    public function testGetComparerOperandSettingOnlyPropertyPath()
    {
        $c = $this->getComparer();
        $p = m::mock('Symfony\Component\PropertyAccess\PropertyPathInterface');
        $c->setPropertyPath($p);

        $result = $c->getComparerOperand('element');
        $this->assertSame('element', $result);
    }

    public function testGetComparerOperand()
    {
        $c = $this->getComparer();
        $a = m::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface');
        $p = m::mock('Symfony\Component\PropertyAccess\PropertyPathInterface');

        $data = array(
            'firstName' => 'A first name',
            'lastName'  => 'A last name'
        );

        $a->shouldReceive('getValue')->once()->andReturn('Your first name');
        $c->setPropertyAccessor($a);
        $c->setPropertyPath($p);

        $result = $c->getComparerOperand($data);
        $this->assertSame('Your first name', $result);
    }
}
