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
use DoctrineSortableCollections\Comparer\CallbackComparer;

/**
 * Class CallbackComparerTest.
 *
 * @todo Add tests for all callables.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class CallbackComparerTest extends PHPUnit_Framework_TestCase
{
    public function testSetAndGetCallback()
    {
        $closure = function ($e1, $e2, $c) {
            // Empty closure
        };
        $c       = new CallbackComparer($closure);

        $closure = function ($e1, $e2, $c) {
            if ($e1 < $e2) {
                return ($c->isAsc()) ? -1 : 1;
            } elseif ($e1 == $e2) {
                return 0;
            } else {
                return ($c->isAsc()) ? 1 : -1;
            }
        };

        $result = $c->setCallback($closure);
        $this->assertInstanceOf('DoctrineSortableCollections\Comparer\CallbackComparer', $result);

        $result = $c->getCallback();
        $this->assertSame($closure, $result);
    }

    public function testClosure()
    {
        $closure = function ($e1, $e2, $c) {
            if ($e1 < $e2) {
                return ($c->isAsc()) ? -1 : 1;
            } elseif ($e1 == $e2) {
                return 0;
            } else {
                return ($c->isAsc()) ? 1 : -1;
            }
        };
        $c       = new CallbackComparer($closure);

        $result = $c->compare(1, 2);
        $this->assertSame(-1, $result);

        $result = $c->compare(2, 2);
        $this->assertSame(0, $result);

        $result = $c->compare(2, 1);
        $this->assertSame(1, $result);

        $c->setDirection(Comparer::DESC);

        $result = $c->compare(1, 2);
        $this->assertSame(1, $result);

        $result = $c->compare(2, 2);
        $this->assertSame(0, $result);

        $result = $c->compare(2, 1);
        $this->assertSame(-1, $result);
    }

    public function testAnonymousFunction()
    {
        $c = new CallbackComparer(function ($e1, $e2, $c) {
            if ($e1 < $e2) {
                return ($c->isAsc()) ? -1 : 1;
            } elseif ($e1 == $e2) {
                return 0;
            } else {
                return ($c->isAsc()) ? 1 : -1;
            }
        });

        $result = $c->compare(1, 2);
        $this->assertSame(-1, $result);

        $result = $c->compare(2, 2);
        $this->assertSame(0, $result);

        $result = $c->compare(2, 1);
        $this->assertSame(1, $result);

        $c->setDirection(Comparer::DESC);

        $result = $c->compare(1, 2);
        $this->assertSame(1, $result);

        $result = $c->compare(2, 2);
        $this->assertSame(0, $result);

        $result = $c->compare(2, 1);
        $this->assertSame(-1, $result);
    }

    public function testWithPropertyAccessor()
    {
        $closure = function ($e1, $e2, $c) {
            if ($e1 < $e2) {
                return ($c->isAsc()) ? -1 : 1;
            } elseif ($e1 == $e2) {
                return 0;
            } else {
                return ($c->isAsc()) ? 1 : -1;
            }
        };
        $c       = new CallbackComparer($closure);
        $a       = m::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface');
        $p       = m::mock('Symfony\Component\PropertyAccess\PropertyPathInterface');

        $age1 = 1;
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
        $this->assertSame(0, $result);
    }
}
