<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace DoctrineSortableCollections;

use DoctrineSortableCollections\Comparer\ComparerInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class SortableArrayCollection.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class SortableArrayCollection extends ArrayCollection implements SortableInterface
{
    /**
     * Replace current elements with new ones.
     *
     * Note: This method isn't necessary if $_elements will be converted from
     * private to protected. In this way performace will be improved as well.
     *
     * @param array $elements array of sorted elements used to replace the original
     * ones
     *
     * @return void
     */
    protected function replace(array $elements)
    {
        $this->clear();

        foreach ($elements as $element) {
            $this->add($element);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sort(ComparerInterface $comparer)
    {
        $elements = $this->toArray();
        @usort($elements, array($comparer, 'compare'));
        $this->replace($elements);

        return $this;
    }
}