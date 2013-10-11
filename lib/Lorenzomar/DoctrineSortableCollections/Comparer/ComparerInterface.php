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

/**
 * Interface ComparerInterface.
 *
 * Interface for the comparer
 *
 * @package Lorenzomar\DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
interface ComparerInterface
{
    /**
     * Compare two element of a collection
     *
     * Return:
     * $o1 < $o2: 1
     * $o1 == $o2: 0
     * $o1 > $o2: -1
     *
     * @param mixed $e1 first element of comparison
     * @param mixed $e2 second element of comparison
     *
     * @return mixed
     */
    public function compare($e1, $e2);
}