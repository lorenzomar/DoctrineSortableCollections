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
use Lorenzomar\DoctrineSortableCollections\Comparer\Comparer;

class ComparerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Comparer
     */
    private $comparer;

    protected function setUp()
    {
        $this->comparer = m::mock('Comparer');
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructWithAscDirection()
    {
        $this->comparer->shouldReceive('getDirection')->andReturn('ASC');
        $this->assertTrue($this->comparer->getDirection() === Comparer::ASC);
    }

    public function testSetAndGetDirection()
    {
        $this->comparer->shouldReceive('setDirection')->with(Comparer::DESC)->andReturn(Mockery::self());
        $this->assertInstanceOf('Comparer', $this->comparer->setDirection(Comparer::DESC));

        $this->comparer->shouldReceive('getDirection')->withNoArgs()->andReturn(Comparer::DESC);
        $this->assertTrue($this->comparer->getDirection() === Comparer::DESC);
    }

    public function testSetDirectionException()
    {
        $this->comparer->shouldReceive('setDirection')->with('randomValue')->andThrow(new InvalidArgumentException('Wrong direction'));

        $this->setExpectedException('InvalidArgumentException');
        $this->comparer->setDirection('randomValue');
    }
}
