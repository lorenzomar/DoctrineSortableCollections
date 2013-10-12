<?php

/*
 * This file is part of the Lorenzomar\PHPEuroCV package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lorenzomar\DoctrineSortableCollections\Comparer;

use Lorenzomar\DoctrineSortableCollections\Comparer\Comparer;

class DateTimeComparer extends Comparer
{
    public function compare($e1, $e2)
    {
        if (!$e1 instanceof \DateTime) {
            throw new \InvalidArgumentException("Wrong type. '$e1' must be an instance of DateTime.'");
        }

        if (!$e2 instanceof \DateTime) {
            throw new \InvalidArgumentException("Wrong type. '$e2' must be an instance of DateTime.'");
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