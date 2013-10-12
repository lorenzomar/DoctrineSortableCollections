<?php

/*
 * This file is part of the Lorenzomar\PHPEuroCV package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mockery as m;
use Lorenzomar\DoctrineSortableCollections\SortableArrayCollection;
use Lorenzomar\DoctrineSortableCollections\Comparer\Comparer;
use Lorenzomar\DoctrineSortableCollections\Comparer\CallbackComparer;

/**
 * Class CallbackComparerTest.
 *
 * @todo Add tests for all callables.
 *
 * @package Lorenzomar\PHPEuroCV
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/PHPEuroCV
 */
class CallbackComparerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SortableArrayCollection
     */
    protected $collection;

    protected function setUp()
    {
        $this->collection = new SortableArrayCollection();
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('Lorenzomar\DoctrineSortableCollections\SortableInterface', $this->collection);
    }

    public function testClosure()
    {
        $c = function ($e1, $e2) {
            if ($e1 < $e2) {
                return -1;
            } elseif ($e1 === $e2) {
                return 0;
            } else {
                return 1;
            }
        };

        $comparer = new CallbackComparer($c);

        $compareResult = $comparer->compare(1, 2);
        $this->assertSame(-1, $compareResult);

        $compareResult = $comparer->compare(2, 2);
        $this->assertSame(0, $compareResult);

        $compareResult = $comparer->compare(2, 1);
        $this->assertSame(1, $compareResult);
    }

    public function testAnonymousFunction()
    {
        $comparer = new CallbackComparer(function ($e1, $e2) {
            if ($e1 < $e2) {
                return -1;
            } elseif ($e1 === $e2) {
                return 0;
            } else {
                return 1;
            }
        });

        $compareResult = $comparer->compare(1, 2);
        $this->assertSame(-1, $compareResult);

        $compareResult = $comparer->compare(2, 2);
        $this->assertSame(0, $compareResult);

        $compareResult = $comparer->compare(2, 1);
        $this->assertSame(1, $compareResult);
    }
}
