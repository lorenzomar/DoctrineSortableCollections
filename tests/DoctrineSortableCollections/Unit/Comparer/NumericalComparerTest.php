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
use DoctrineSortableCollections\SortableArrayCollection;
use DoctrineSortableCollections\Comparer\Comparer;
use DoctrineSortableCollections\Comparer\NumericalComparer;

/**
 * Class NumericalComparerTest.
 *
 * @todo write test for binary, octal and hex numbers
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class NumericalComparerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var NumericalComparer
     */
    protected $comparer;

    protected function setUp()
    {
        $this->comparer = new NumericalComparer();
    }

    public function testThrowExceptionOnEmptyArguments()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->comparer->compare('', '');
    }

    public function testThrowExceptionOnStringArguments()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->comparer->compare('string1', 'string2');
    }

    public function testNumericStringArguments()
    {
        $result = $this->comparer->compare('2', '3');
        $this->assertSame(-1, $result);
    }

    public function testMixedArguments()
    {
        $result = $this->comparer->compare('2', 3);
        $this->assertSame(-1, $result);
    }

    public function testIntArgumentsAscDirection()
    {
        $c = $this->comparer;

        $result = $c->compare(2, 3);
        $this->assertSame(-1, $result);

        $result = $c->compare(2, 2);
        $this->assertSame(0, $result);

        $result = $c->compare(3, 2);
        $this->assertSame(1, $result);
    }

    public function testIntArgumentsDescDirection()
    {
        $c = $this->comparer;
        $c->setDirection(Comparer::DESC);

        $result = $c->compare(2, 3);
        $this->assertSame(1, $result);

        $result = $c->compare(2, 2);
        $this->assertSame(0, $result);

        $result = $c->compare(3, 2);
        $this->assertSame(-1, $result);
    }

    public function testFloatArguments()
    {
        $c = $this->comparer;

        $result = $c->compare(2.01, 3.785);
        $this->assertSame(-1, $result);

        $result = $c->compare(2.01, 2.01);
        $this->assertSame(0, $result);

        $result = $c->compare(3.785, 2.01);
        $this->assertSame(1, $result);
    }

    public function testFloatArgumentsDescDirectino()
    {
        $c = $this->comparer;
        $c->setDirection(Comparer::DESC);

        $result = $c->compare(2.01, 3.785);
        $this->assertSame(1, $result);

        $result = $c->compare(2.01, 2.01);
        $this->assertSame(0, $result);

        $result = $c->compare(3.785, 2.01);
        $this->assertSame(-1, $result);
    }

    public function testWithPropertyAccessor()
    {
        $c = $this->comparer;
        $a = m::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface');
        $p = m::mock('Symfony\Component\PropertyAccess\PropertyPathInterface');

        $age1 = 0;
        $age2 = 1;
        $data = array(
            array(
                'firstName' => 'A first name',
                'lastName'  => 'A last name',
                'age'       => $age1
            ),
            array(
                'firstName' => 'A second first name',
                'lastName'  => 'A second last name',
                'age'       => $age2
            )
        );

        $a->shouldReceive('getValue')->twice()->andReturn($age1, $age2);
        $c->setPropertyAccessor($a);
        $c->setPropertyPath($p);

        $result = $c->compare($data[0], $data[1]);
        $this->assertSame(-1, $result);
    }
}
