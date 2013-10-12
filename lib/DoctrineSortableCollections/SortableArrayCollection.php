<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineSortableCollections;

use DoctrineSortableCollections\SortableInterface;
use DoctrineSortableCollections\Comparer\ComparerInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class SortableArrayCollection.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class SortableArrayCollection extends ArrayCollection implements SortableInterface
{
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

    /**
     * Replace current collection elements with new ones.
     *
     * Note: This method isn't necessary if $_elements will be converted from
     * private to protected
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
}