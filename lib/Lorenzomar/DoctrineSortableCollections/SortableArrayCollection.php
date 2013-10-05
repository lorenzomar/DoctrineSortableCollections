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

use Lorenzomar\DoctrineSortableCollections\SortableInterface;
use Lorenzomar\DoctrineSortableCollections\ComparerInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class SortableArrayCollection.
 *
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package Lorenzomar\DoctrineSortableCollections
 */
class SortableArrayCollection extends ArrayCollection implements SortableInterface
{
    /**
     * Replace current collection elements with new ones.
     *
     * Note: This method isn't necessary if $_elements will be converted from
     * private to protected
     *
     * @param array $elements
     * @return void
     */
    protected function replace(array $elements)
    {
        $this->clear();

        foreach($elements as $element)
        {
            $this->add($element);
        }
    }

    /**
     * @param ComparerInterface $comparer
     * @return self
     */
    public function sort(ComparerInterface $comparer)
    {
        $elements = $this->toArray();
        usort($elements, array($comparer, 'compare'));
        $this->replace($elements);

        return $this;
    }
}