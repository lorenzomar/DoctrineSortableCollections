<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace DoctrineSortableCollections;

use DoctrineSortableCollections\Comparer\ComparerInterface;
use Doctrine\Common\Collections\Collection;

/**
 * Interface SortableInterface.
 *
 * Interface for the sortable collections
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
interface SortableInterface
{
    /**
     * Sortable collections must implement this method and return
     * the collection itself.
     *
     * @param ComparerInterface $comparer implementation of ComparerInterface used to
     * sort the collection
     *
     * @return Collection
     */
    public function sort(ComparerInterface $comparer);
}