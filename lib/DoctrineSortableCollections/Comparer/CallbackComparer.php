<?php

/*
 * This file is part of the DoctrineSortableCollections.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace DoctrineSortableCollections\Comparer;

/**
 * Class CallbackComparer.
 *
 * @package DoctrineSortableCollections
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    www.github.com/lorenzomar/doctrine-sortable-collections
 */
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
        $this->setCallback($callback);

        parent::__construct($direction);
    }

    /**
     * @param $callback
     *
     * @throws \InvalidArgumentException
     * @return self
     */
    public function setCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException("Wrong type. '$callback' must be callable");
        }

        $this->callback = $callback;

        return $this;
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
        $e1 = $this->getComparerOperand($e1);
        $e2 = $this->getComparerOperand($e2);

        return call_user_func($this->getCallback(), $e1, $e2, $this);
    }
}