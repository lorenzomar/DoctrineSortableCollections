<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace DoctrineSortableCollections\Comparer;

/**
 * Class NumericalComparer.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class NumericalComparer extends Comparer
{
    /**
     * {@inheritdoc}
     *
     * @param mixed $e1
     * @param mixed $e2
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function compare($e1, $e2)
    {
        $e1 = $this->getComparerOperand($e1);
        $e2 = $this->getComparerOperand($e2);

        if (!is_numeric($e1)) {
            throw new \InvalidArgumentException('Wrong type. $e1 must be a number.');
        }

        if (!is_numeric($e2)) {
            throw new \InvalidArgumentException('Wrong type. $e2 must be a number.');
        }

        if ($e1 < $e2) {
            return ($this->getDirection() === self::ASC) ? -1 : 1;
        } elseif ($e1 == $e2) {
            return 0;
        } else {
            return ($this->getDirection() === self::ASC) ? 1 : -1;
        }
    }
}