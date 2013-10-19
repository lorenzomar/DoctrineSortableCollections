<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use DoctrineSortableCollections\Comparer\Comparer;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;

/**
 * Class ComparerWithPropertyAccessorTest.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class ComparerWithPropertyAccessorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Comparer
     */
    protected $comparer;

    /**
     * @var PropertyAccessor
     */
    protected $propertyAccessor;

    protected function setUp()
    {
        $this->comparer = $this->getMockForAbstractClass('DoctrineSortableCollections\Comparer\Comparer');
        $this->comparer->setPropertyAccessor(PropertyAccess::createPropertyAccessor());
    }

    public function testGetComparerOperand()
    {
        $c       = $this->comparer;
        $element = array(
            'firstName' => 'A first name',
            'lastName'  => 'A last name',
            'email'     => 'email@provider.com'
        );

        $c->setPropertyPath(new PropertyPath('[firstName]'));
        $result = $c->getComparerOperand($element);
        $this->assertSame('A first name', $result);

        $c->setPropertyPath(new PropertyPath('[lastName]'));
        $result = $c->getComparerOperand($element);
        $this->assertSame('A last name', $result);

        $c->setPropertyPath(new PropertyPath('[email]'));
        $result = $c->getComparerOperand($element);
        $this->assertSame('email@provider.com', $result);
    }
}
