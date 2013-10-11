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
use Lorenzomar\DoctrineSortableCollections\Comparer\NumericalComparer;

/**
 * Class NumericalComparerTest.
 *
 * @todo write test for binary, octal and hex numbers
 *
 * @package Lorenzomar\PHPEuroCV
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/PHPEuroCV
 */
class NumericalComparerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SortableArrayCollection
     */
    private $collection;

    /**
     * @var NumericalComparer
     */
    private $comparer;

    protected function setUp()
    {
        $this->collection = new SortableArrayCollection();
        $this->comparer = new NumericalComparer();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('Lorenzomar\DoctrineSortableCollections\SortableInterface', $this->collection);
        $this->assertInstanceOf('Lorenzomar\DoctrineSortableCollections\Comparer\NumericalComparer', $this->comparer);
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

    public function testIntArguments()
    {
        $compareResult = $this->comparer->compare(2, 3);
        $this->assertSame(-1, $compareResult);

        $compareResult = $this->comparer->compare(2, 2);
        $this->assertSame(0, $compareResult);

        $compareResult = $this->comparer->compare(3, 2);
        $this->assertSame(1, $compareResult);
    }

    public function testIntArgumentsDescDirection()
    {
        $this->comparer->setDirection(Comparer::DESC);

        $compareResult = $this->comparer->compare(2, 3);
        $this->assertSame(1, $compareResult);

        $compareResult = $this->comparer->compare(2, 2);
        $this->assertSame(0, $compareResult);

        $compareResult = $this->comparer->compare(3, 2);
        $this->assertSame(-1, $compareResult);
    }

    public function testFloatArguments()
    {
        $compareResult = $this->comparer->compare(2.01, 3.785);
        $this->assertSame(-1, $compareResult);

        $compareResult = $this->comparer->compare(2.01, 2.01);
        $this->assertSame(0, $compareResult);

        $compareResult = $this->comparer->compare(3.785, 2.01);
        $this->assertSame(1, $compareResult);
    }

    public function testFloatArgumentsDescDirectino()
    {
        $this->comparer->setDirection(Comparer::DESC);

        $compareResult = $this->comparer->compare(2.01, 3.785);
        $this->assertSame(1, $compareResult);

        $compareResult = $this->comparer->compare(2.01, 2.01);
        $this->assertSame(0, $compareResult);

        $compareResult = $this->comparer->compare(3.785, 2.01);
        $this->assertSame(-1, $compareResult);
    }

    public function testNumericStringArguments()
    {
        $compareResult = $this->comparer->compare('2', '3');
        $this->assertSame(-1, $compareResult);
    }

    public function testMixedArguments()
    {
        $compareResult = $this->comparer->compare('2', 3);
        $this->assertSame(-1, $compareResult);
    }
}
