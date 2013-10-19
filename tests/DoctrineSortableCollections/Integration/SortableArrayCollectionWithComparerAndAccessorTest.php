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
use DoctrineSortableCollections\SortableArrayCollection;
use DoctrineSortableCollections\Comparer\DateTimeComparer;
use DoctrineSortableCollections\Comparer\NumericalComparer;
use DoctrineSortableCollections\Comparer\CallbackComparer;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class SortableArrayCollectionWithComparerAndAccessorTest.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class SortableArrayCollectionWithComparerAndAccessorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SortableArrayCollection
     */
    protected $collection;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    protected function setUp()
    {
        $this->collection = new SortableArrayCollection(array(
            array(
                'firstName' => 'First name 1',
                'lastName'  => 'Last name 1',
                'age'       => 22,
                'birthDate' => DateTime::createFromFormat('Y-m-d H:i:s', '1988-07-30 00:00:01')
            ),
            array(
                'firstName' => 'First name 2',
                'lastName'  => 'Last name 2',
                'age'       => 17,
                'birthDate' => DateTime::createFromFormat('Y-m-d H:i:s', '1992-01-06 14:54:23')
            ),
            array(
                'firstName' => 'First name 3',
                'lastName'  => 'Last name 3',
                'age'       => 56,
                'birthDate' => DateTime::createFromFormat('Y-m-d H:i:s', '1958-03-19 22:00:00')
            ),
            array(
                'firstName' => 'First name 4',
                'lastName'  => 'Last name 4',
                'age'       => 30,
                'birthDate' => DateTime::createFromFormat('Y-m-d H:i:s', '1977-11-30 10:45:00')
            ),
            array(
                'firstName' => 'First name 5',
                'lastName'  => 'Last name 5',
                'age'       => 11,
                'birthDate' => DateTime::createFromFormat('Y-m-d H:i:s', '2000-10-13 15:35:01')
            ),
        ));

        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param $comparer
     *
     * @return CallbackComparer|DateTimeComparer|NumericalComparer
     */
    protected function comparerFactory($comparer)
    {
        switch ($comparer) {
            case 'DateTime':
                return new DateTimeComparer();
                break;

            case 'Numerical':
                return new NumericalComparer();
                break;

            case 'Callback':
                $callback = func_get_arg(1);

                return new CallbackComparer($callback);
                break;
        }
    }

    public function testNumericalComparer()
    {
        $collection       = $this->collection;
        $propertyAccessor = $this->accessor;
        $propertyPath     = new PropertyPath('[age]');
        $comparer         = $this->comparerFactory('Numerical');

        $comparer->setPropertyAccessor($propertyAccessor);
        $comparer->setPropertyPath($propertyPath);

        $collection->sort($comparer);
        $this->assertSame(11, $propertyAccessor->getValue($collection->get(0), $propertyPath));
        $this->assertSame(17, $propertyAccessor->getValue($collection->get(1), $propertyPath));
        $this->assertSame(22, $propertyAccessor->getValue($collection->get(2), $propertyPath));
        $this->assertSame(30, $propertyAccessor->getValue($collection->get(3), $propertyPath));
        $this->assertSame(56, $propertyAccessor->getValue($collection->get(4), $propertyPath));
    }

    public function testNumericalComparerDesc()
    {
        $collection       = $this->collection;
        $propertyAccessor = $this->accessor;
        $propertyPath     = new PropertyPath('[age]');
        $comparer         = $this->comparerFactory('Numerical');

        $comparer->setPropertyAccessor($propertyAccessor);
        $comparer->setPropertyPath($propertyPath);
        $comparer->setDirection(Comparer::DESC);

        $collection->sort($comparer);
        $this->assertSame(56, $propertyAccessor->getValue($collection->get(0), $propertyPath));
        $this->assertSame(30, $propertyAccessor->getValue($collection->get(1), $propertyPath));
        $this->assertSame(22, $propertyAccessor->getValue($collection->get(2), $propertyPath));
        $this->assertSame(17, $propertyAccessor->getValue($collection->get(3), $propertyPath));
        $this->assertSame(11, $propertyAccessor->getValue($collection->get(4), $propertyPath));
    }

    public function testDateTimeComparer()
    {
        $collection       = $this->collection;
        $propertyAccessor = $this->accessor;
        $propertyPath     = new PropertyPath('[birthDate]');
        $comparer         = $this->comparerFactory('DateTime');

        $comparer->setPropertyAccessor($propertyAccessor);
        $comparer->setPropertyPath($propertyPath);

        $collection->sort($comparer);
        $this->assertSame(
            '1958-03-19 22:00:00',
            $propertyAccessor->getValue($collection->get(0), $propertyPath)->format('Y-m-d H:i:s')
        );
        $this->assertSame(
            '1977-11-30 10:45:00',
            $propertyAccessor->getValue($collection->get(1), $propertyPath)->format('Y-m-d H:i:s')
        );
        $this->assertSame(
            '1988-07-30 00:00:01',
            $propertyAccessor->getValue($collection->get(2), $propertyPath)->format('Y-m-d H:i:s')
        );
        $this->assertSame(
            '1992-01-06 14:54:23',
            $propertyAccessor->getValue($collection->get(3), $propertyPath)->format('Y-m-d H:i:s')
        );
        $this->assertSame(
            '2000-10-13 15:35:01',
            $propertyAccessor->getValue($collection->get(4), $propertyPath)->format('Y-m-d H:i:s')
        );
    }

    public function testDateTimeComparerDesc()
    {
        $collection       = $this->collection;
        $propertyAccessor = $this->accessor;
        $propertyPath     = new PropertyPath('[birthDate]');
        $comparer         = $this->comparerFactory('DateTime');

        $comparer->setPropertyAccessor($propertyAccessor);
        $comparer->setPropertyPath($propertyPath);
        $comparer->setDirection(Comparer::DESC);

        $collection->sort($comparer);
        $this->assertSame(
            '2000-10-13 15:35:01',
            $propertyAccessor->getValue($collection->get(0), $propertyPath)->format('Y-m-d H:i:s')
        );
        $this->assertSame(
            '1992-01-06 14:54:23',
            $propertyAccessor->getValue($collection->get(1), $propertyPath)->format('Y-m-d H:i:s')
        );
        $this->assertSame(
            '1988-07-30 00:00:01',
            $propertyAccessor->getValue($collection->get(2), $propertyPath)->format('Y-m-d H:i:s')
        );
        $this->assertSame(
            '1977-11-30 10:45:00',
            $propertyAccessor->getValue($collection->get(3), $propertyPath)->format('Y-m-d H:i:s')
        );
        $this->assertSame(
            '1958-03-19 22:00:00',
            $propertyAccessor->getValue($collection->get(4), $propertyPath)->format('Y-m-d H:i:s')
        );
    }

    public function testCallbackComparer()
    {
        $collection       = $this->collection;
        $propertyAccessor = $this->accessor;
        $propertyPath     = new PropertyPath('[firstName]');
        $comparer         = $this->comparerFactory(
            'Callback',
            function ($e1, $e2, $c) {
                return strcmp($e1, $e2);
            }
        );

        $comparer->setPropertyAccessor($propertyAccessor);
        $comparer->setPropertyPath($propertyPath);

        $collection->sort($comparer);
        $this->assertSame(
            'First name 1',
            $propertyAccessor->getValue($collection->get(0), $propertyPath)
        );
        $this->assertSame(
            'First name 2',
            $propertyAccessor->getValue($collection->get(1), $propertyPath)
        );
        $this->assertSame(
            'First name 3',
            $propertyAccessor->getValue($collection->get(2), $propertyPath)
        );
        $this->assertSame(
            'First name 4',
            $propertyAccessor->getValue($collection->get(3), $propertyPath)
        );
        $this->assertSame(
            'First name 5',
            $propertyAccessor->getValue($collection->get(4), $propertyPath)
        );
    }

    public function testCallbackComparerDesc()
    {
        $collection       = $this->collection;
        $propertyAccessor = $this->accessor;
        $propertyPath     = new PropertyPath('[firstName]');
        $comparer         = $this->comparerFactory(
            'Callback',
            function ($e1, $e2, $c) {
                $result = strcmp($e1, $e2);

                if ($result < 0) {
                    return 1;
                } elseif ($result === 0) {
                    return 0;
                } else {
                    return -1;
                }
            }
        );

        $comparer->setPropertyAccessor($propertyAccessor);
        $comparer->setPropertyPath($propertyPath);
        $comparer->setDirection(Comparer::DESC);

        $collection->sort($comparer);
        $this->assertSame(
            'First name 5',
            $propertyAccessor->getValue($collection->get(0), $propertyPath)
        );
        $this->assertSame(
            'First name 4',
            $propertyAccessor->getValue($collection->get(1), $propertyPath)
        );
        $this->assertSame(
            'First name 3',
            $propertyAccessor->getValue($collection->get(2), $propertyPath)
        );
        $this->assertSame(
            'First name 2',
            $propertyAccessor->getValue($collection->get(3), $propertyPath)
        );
        $this->assertSame(
            'First name 1',
            $propertyAccessor->getValue($collection->get(4), $propertyPath)
        );
    }
}
