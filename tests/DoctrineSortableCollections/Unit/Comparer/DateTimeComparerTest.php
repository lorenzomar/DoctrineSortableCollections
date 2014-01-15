<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace DoctrineSortableCollections\Tests\Unit\Comparer;

use Mockery as m;
use DoctrineSortableCollections\Comparer\Comparer;
use DoctrineSortableCollections\Comparer\DateTimeComparer;

/**
 * Class DateTimeComparerTest.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class DateTimeComparerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateTimeComparer
     */
    protected $comparer;

    protected function setUp()
    {
        $this->comparer = new DateTimeComparer();
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

    public function testAscDirection()
    {
        $d1 = \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-10 11:00:00');
        $d2 = \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-12 11:00:00');

        $result = $this->comparer->compare($d1, $d2);
        $this->assertSame(-1, $result);

        $result = $this->comparer->compare($d1, $d1);
        $this->assertSame(0, $result);

        $result = $this->comparer->compare($d2, $d1);
        $this->assertSame(1, $result);
    }

    public function testDescDirection()
    {
        $c = $this->comparer;
        $c->setDirection(Comparer::DESC);

        $d1 = \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-10 11:00:00');
        $d2 = \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-12 11:00:00');

        $result = $c->compare($d1, $d2);
        $this->assertSame(1, $result);

        $result = $c->compare($d1, $d1);
        $this->assertSame(0, $result);

        $result = $c->compare($d2, $d1);
        $this->assertSame(-1, $result);
    }

    public function testWithPropertyAccessor()
    {
        $c = $this->comparer;
        $a = m::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface');
        $p = m::mock('Symfony\Component\PropertyAccess\PropertyPathInterface');

        $date1 = \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-01 11:00:00');
        $date2 = \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-02 11:00:00');
        $data  = array(
            array(
                'firstName' => 'A first name',
                'lastName'  => 'A last name',
                'birthDate' => $date1
            ),
            array(
                'firstName' => 'A second first name',
                'lastName'  => 'A second last name',
                'birthDate' => $date2
            )
        );

        $a->shouldReceive('getValue')->twice()->andReturn($date1, $date2);
        $c->setPropertyAccessor($a);
        $c->setPropertyPath($p);

        $result = $c->compare($data[0], $data[1]);
        $this->assertSame(-1, $result);
    }
}
