<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace DoctrineSortableCollections\Tests\Unit;

use \Mockery as m;
use DoctrineSortableCollections\SortableArrayCollection;

/**
 * Class SortableArrayCollectionTest.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class SortableArrayCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SortableArrayCollection
     */
    protected $collection;

    protected function setUp()
    {
        $this->collection = new SortableArrayCollection();

        /**
         * Emulate an implementation of ComparerInterface to use with sort method
         */
        $this->comparer = m::mock('stdClass, DoctrineSortableCollections\Comparer\ComparerInterface');
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testSortEmptyCollection()
    {
        $c = $this->comparer;

        $c->shouldReceive('compare')->never();
        $this->assertTrue($this->collection->isEmpty());
        $this->collection->sort($c);
        $this->assertTrue($this->collection->isEmpty());
    }

    public function testSortCollectionWith1Element()
    {
        $coll = $this->collection;
        $comp = $this->comparer;
        $comp->shouldReceive('compare')->never();

        $this->assertTrue($coll->isEmpty());
        $coll->add(1);
        $this->assertCount(1, $coll);
        $this->collection->sort($comp);
        $this->assertCount(1, $coll);
    }

    public function testSortCollectionWith2OrMoreElements()
    {
        $coll = $this->collection;
        $comp = $this->comparer;
        $comp->shouldReceive('compare')->andReturnUsing(
            function ($e1, $e2) {
                if ($e1 < $e2) {
                    return -1;
                } elseif ($e1 == $e2) {
                    return 0;
                } else {
                    return 1;
                }
            }
        );

        $coll->add(2);
        $coll->add(1);
        $coll->sort($comp);
        $this->assertEquals(array(1, 2), $coll->toArray());

        $coll->add(5);
        $coll->add(9);
        $coll->add(7);
        $coll->sort($comp);
        $this->assertEquals(array(1, 2, 5, 7, 9), $coll->toArray());
    }
}
