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

use Lorenzomar\DoctrineSortableCollections\ComparerInterface;
use Doctrine\Common\Collections\Collection;

/**
 * Interface SortableInterface.
 *
 * Interface for the sortable collection
 *
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package Lorenzomar\DoctrineSortableCollections
 */
interface SortableInterface
{
    /**
     * Sortable collections must implement this method and return
     * the collection itself.
     *
     * @param ComparerInterface $comparer
     * @return Collection
     */
    public function sort(ComparerInterface $comparer);
}