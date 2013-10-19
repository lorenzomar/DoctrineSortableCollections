<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineSortableCollections\Comparer;

use DoctrineSortableCollections\Comparer\Comparer;

/**
 * Class DateTimeComparer.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
class DateTimeComparer extends Comparer
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

        if (!$e1 instanceof \DateTime) {
            throw new \InvalidArgumentException('Wrong type. $e1 must be an instance of DateTime.');
        }

        if (!$e2 instanceof \DateTime) {
            throw new \InvalidArgumentException('Wrong type. $e2 must be an instance of DateTime.');
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