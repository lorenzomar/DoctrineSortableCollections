<?php
/*
 * This file is part of the Lorenzomar\DoctrineSortableCollections package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lorenzomar\DoctrineSortableCollections;

/**
 * Interface ComparerInterface.
 *
 * Interface for the comparer
 *
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package Lorenzomar\DoctrineSortableCollections
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
     * @param mixed $o1
     * @param mixed $o2
     * @return mixed
     */
    public function compare($o1, $o2);
}