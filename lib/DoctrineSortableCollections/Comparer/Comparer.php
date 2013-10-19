<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineSortableCollections\Comparer;

use DoctrineSortableCollections\Comparer\ComparerInterface;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class Comparer.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
abstract class Comparer implements ComparerInterface
{
    const ASC  = 'ASC';
    const DESC = 'DESC';

    /**
     * @var null|PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @var null|PropertyPathInterface
     */
    private $propertyPath;

    /**
     * @var string $direction
     */
    private $direction;

    /**
     * @param string $direction
     */
    public function __construct($direction = self::ASC)
    {
        $this->setDirection($direction);
        $this->setPropertyAccessor(null);
        $this->setPropertyPath(null);
    }

    /**
     * @param string $direction
     *
     * @throws \InvalidArgumentException
     * @return self
     */
    public function setDirection($direction)
    {
        if (!is_string($direction) || (strtoupper($direction) !== self::ASC && strtoupper($direction) !== self::DESC)) {
            throw new \InvalidArgumentException("Wrong direction");
        }

        $direction = strtoupper($direction);


        $this->direction = $direction;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @return bool
     */
    public function isAsc()
    {
        return $this->getDirection() === self::ASC;
    }

    /**
     * @return bool
     */
    public function isDesc()
    {
        return $this->getDirection() === self::DESC;
    }

    /**
     * @param null|PropertyAccessorInterface $propertyAccessor
     *
     * @throws \InvalidArgumentException
     * @return self
     */
    public function setPropertyAccessor($propertyAccessor)
    {
        if (!is_null($propertyAccessor) && !($propertyAccessor instanceof PropertyAccessorInterface)) {
            throw new \InvalidArgumentException("propertyAccessor must be null or an instance of PropertyAccessorInterface");
        }

        $this->propertyAccessor = $propertyAccessor;

        return $this;
    }

    /**
     * @return null|PropertyAccessorInterface
     */
    public function getPropertyAccessor()
    {
        return $this->propertyAccessor;
    }

    /**
     * @return bool
     */
    public function hasPropertyAccessor()
    {
        return $this->getPropertyAccessor() instanceof PropertyAccessorInterface;
    }

    /**
     * @param null|PropertyPathInterface $path
     *
     * @throws \InvalidArgumentException
     * @return self
     */
    public function setPropertyPath($path)
    {
        if (!is_null($path) && !($path instanceof PropertyPathInterface)) {
            throw new \InvalidArgumentException("Wrong path. Excepted values could be null or an instance of PropertyPathInterface");
        }

        $this->propertyPath = $path;

        return $this;
    }

    /**
     * @return null|PropertyPathInterface
     */
    public function getPropertyPath()
    {
        return $this->propertyPath;
    }

    /**
     * @return bool
     */
    public function hasPropertyPath()
    {
        return $this->getPropertyPath() instanceof PropertyPathInterface;
    }

    /**
     * Extract comparer operand from element.
     *
     * This method take care to retrieve the right operand to use in a
     * compare operation, using the Symfony Property Accessor component.
     * In this way the elements could be anything from simple string to
     * complex objects.
     * If propertyPath is null the current element will be returned.
     *
     * compare method in subclasses should use getComparerOperand to
     * retrieve the value used in comparison.
     *
     * @param mixed $element
     *
     * @return mixed
     */
    public function getComparerOperand($element)
    {
        if ($this->hasPropertyAccessor() && $this->hasPropertyPath()) {
            return $this->getPropertyAccessor()->getValue($element, $this->getPropertyPath());
        }

        return $element;
    }
}