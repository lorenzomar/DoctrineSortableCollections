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

class CallbackComparer extends Comparer
{
    /**
     * @var callback
     */
    protected $callback;

    /**
     * @param callback $callback any type of callable. See http://www.php.net/manual/en/language.types.callable.php
     * @param string $direction
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($callback, $direction = self::ASC)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException("Wrong type. '$callback' must be callable");
        }

        $this->callback = $callback;

        parent::__construct($direction);
    }

    /**
     * @return callback
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * {@inheritdoc}
     */
    public function compare($e1, $e2)
    {
        return call_user_func($this->getCallback(), $e1, $e2);
    }
}