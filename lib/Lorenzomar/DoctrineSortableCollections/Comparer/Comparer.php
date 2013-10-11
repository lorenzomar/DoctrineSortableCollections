<?php

/*
 * This file is part of the Lorenzomar\PHPEuroCV package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lorenzomar\DoctrineSortableCollections\Comparer;

use InvalidArgumentException;
use Lorenzomar\DoctrineSortableCollections\Comparer\ComparerInterface;

/**
 * Class Comparer.
 *
 * @package Lorenzomar\PHPEuroCV
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/PHPEuroCV
 */
abstract class Comparer implements ComparerInterface
{
    const ASC  = 'ASC';
    const DESC = 'DESC';
    /**
     * @var string $direction
     */
    private $direction;

    public function __construct($direction = self::ASC)
    {
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     *
     * @throws InvalidArgumentException
     * @return self
     */
    public function setDirection($direction)
    {
        $direction = strtoupper($direction);

        if ($direction !== self::ASC && $direction !== self::DESC) {
            throw new InvalidArgumentException("Wrong direction");
        }

        $this->direction = $direction;

        return $this;
    }
}