<?php

/*
 * This file is part of the Lorenzomar\PHPEuroCV package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use \Mockery as m;
use Lorenzomar\DoctrineSortableCollections\SortableArrayCollection;
use Lorenzomar\DoctrineSortableCollections\Comparer\ComparerInterface;

class SortableArrayCollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SortableArrayCollection
     */
    protected $collection;

    /**
     * @var ComparerInterface
     */
    protected $comparer;

    protected function setUp()
    {
        $this->collection = new SortableArrayCollection();

        /**
         * Emulate an implementation of ComparerInterface to use with sort method
         */
        $this->comparer = m::mock('stdClass, Lorenzomar\DoctrineSortableCollections\Comparer\ComparerInterface');
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testSortEmptyCollection()
    {
        $this->comparer->shouldReceive('compare')->never();
        $this->assertTrue($this->collection->isEmpty());
        $this->collection->sort($this->comparer);
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
            function($e1, $e2) {
                if($e1 < $e2) return -1;
                elseif($e1 == $e2) return 0;
                else return 1;
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
