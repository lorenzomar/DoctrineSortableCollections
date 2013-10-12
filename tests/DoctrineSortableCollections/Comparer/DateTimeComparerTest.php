<?php

/*
 * This file is part of the Lorenzomar\PHPEuroCV package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Lorenzomar\DoctrineSortableCollections\SortableArrayCollection;
use Lorenzomar\DoctrineSortableCollections\Comparer\Comparer;
use Lorenzomar\DoctrineSortableCollections\Comparer\DateTimeComparer;

class DateTimeComparerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SortableArrayCollection
     */
    protected $collection;

    /**
     * @var DateTimeComparer
     */
    protected $comparer;

    protected function setUp()
    {
        $this->collection = new SortableArrayCollection();
        $this->comparer = new DateTimeComparer();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('Lorenzomar\DoctrineSortableCollections\SortableInterface', $this->collection);
        $this->assertInstanceOf('Lorenzomar\DoctrineSortableCollections\Comparer\DateTimeComparer', $this->comparer);
    }

    public function testDirectionAsc()
    {
        $this->assertSame(Comparer::ASC, $this->comparer->getDirection());
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

    public function testDateTimeArguments()
    {
        $d1 = DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-10 11:00:00');
        $d2 = DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-12 11:00:00');

        $compareResult = $this->comparer->compare($d1, $d2);
        $this->assertSame(-1, $compareResult);

        $compareResult = $this->comparer->compare($d1, $d1);
        $this->assertSame(0, $compareResult);

        $compareResult = $this->comparer->compare($d2, $d1);
        $this->assertSame(1, $compareResult);
    }

    public function testDateTimeArgumentsDescDirection()
    {
        $this->comparer->setDirection(Comparer::DESC);

        $d1 = DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-10 11:00:00');
        $d2 = DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-12 11:00:00');

        $compareResult = $this->comparer->compare($d1, $d2);
        $this->assertSame(1, $compareResult);

        $compareResult = $this->comparer->compare($d1, $d1);
        $this->assertSame(0, $compareResult);

        $compareResult = $this->comparer->compare($d2, $d1);
        $this->assertSame(-1, $compareResult);
    }

    public function testSortCollection()
    {
        $coll = $this->collection;

        $d1 = DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-10 11:00:00');
        $d2 = DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-12 00:05:55');
        $d3 = DateTime::createFromFormat('Y-m-d H:i:s', '2013-09-01 09:37:20');
        $d4 = DateTime::createFromFormat('Y-m-d H:i:s', '2014-03-28 16:00:49');

        $coll->add($d1);
        $coll->add($d2);
        $coll->add($d3);
        $coll->add($d4);

        $coll->sort($this->comparer);
        $this->assertSame(array($d3, $d1, $d2, $d4), $coll->toArray());

        $this->comparer->setDirection(Comparer::DESC);
        $coll->sort($this->comparer);
        $this->assertSame(array($d4, $d2, $d1, $d3), $coll->toArray());
    }
}
