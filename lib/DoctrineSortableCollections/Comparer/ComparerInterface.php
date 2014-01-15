<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace DoctrineSortableCollections\Comparer;

/**
 * Interface ComparerInterface.
 *
 * Interface for the comparer
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
interface ComparerInterface
{
    /**
     * Compare two element of a collection
     *
     * Return:
     * $e1 < $e2: 1
     * $e1 == $e2: 0
     * $e1 > $e2: -1
     *
     * @param mixed $e1 first element of comparison
     * @param mixed $e2 second element of comparison
     *
     * @return mixed
     */
    public function compare($e1, $e2);
}