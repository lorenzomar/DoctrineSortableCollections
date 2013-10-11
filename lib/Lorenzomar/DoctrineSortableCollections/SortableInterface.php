<?php

/*
 * This file is part of the Lorenzomar\PHPEuroCV package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lorenzomar\DoctrineSortableCollections;

use Lorenzomar\DoctrineSortableCollections\Comparer\ComparerInterface;
use Doctrine\Common\Collections\Collection;

/**
 * Interface SortableInterface.
 *
 * Interface for the sortable collections
 *
 * @package Lorenzomar\PHPEuroCV
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/PHPEuroCV
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