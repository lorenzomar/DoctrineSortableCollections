DoctrineSortableCollections
=============================

Questa libreria estende la libreria base di Doctrine aggiungendo funzionalità di ordinamento alle collections.

Installazione
-------------

DoctrineSortableCollections può essere installata usando composer

```
composer require lorenzomar/doctrine-sortable-collections
```

oppure aggiungendola al file composer.json

Utilizzo
--------

`SortableArrayCollection` estende `ArrayCollection` aggiungendo un metodo `sort` grazie al quale sarà possibile ordinare la collection. L'unico parametro richiesto da `sort` è un'istanza di `ComparerInterface`.

I comparatori sono oggetti il cui unico compito è quello di confrontare due elementi della collection e ritornare:
* -1 nel caso in cui il primo elemento > del secondo
* 0 nel caso in cui i due elementi siano identici
* 1 nel caso in cui il primo elemento < del secondo

Attualmente sono presenti 3 comparatori:

1. `NumericalComparer`, in grado di confrontare due valori numerici di qualsiasi formato (interi, float, esadecimali, binari, ottali)
2. `DateTimeComparer`, in grado di confrontare due oggetti `DateTime`
3. `CallbackComparer`, questo comparatore è il più generico di tutti. Confronta due elementi sfruttando una callback che gli viene fornita. Nel caso in cui nessun altro comparatore risulta essere adatto, si può ripiegare su questo

Tutti i comparatori estendono la classe astratta `Comparer` grazie alla quale si può decidere il verso dell'ordinamento (ascendente o discendente). Di default ascendente. E' possibile passare il verso al `__construct` di `Comparer` oppure usando il metodo `setDirection`.

Ordinare liste semplici
-----------------------

Negli esempi che seguono si vedrà come ordinare delle liste composte da elementi semplici (numeri, date, stringhe).

Questo esempio mostra come ordinare una lista di numeri grazie a `NumericalComparer`

```php
use DoctrineSortableCollections\SortableArrayCollection;
use DoctrineSortableCollections\Comparer\Comparer;
use DoctrineSortableCollections\Comparer\NumericalComparer;

$collection = new SortableArrayCollection(array(3, 1, 2));
$ascComparer = NumericalComparer();
$descComparer = NumericalComparer(Comparer::DESC);

$collection->sort($ascComparer); // array(1, 2, 3)
$collection->sort($descComparer); // array(3, 2, 1)
```

Questo esempio mostra come ordinare una lista di date grazie a `DateTimeComparer`

```php
use DoctrineSortableCollections\SortableArrayCollection;
use DoctrineSortableCollections\Comparer\Comparer;
use DoctrineSortableCollections\Comparer\DateTimeComparer;

$collection = new SortableArrayCollection(array(
    \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-02 11:00:00');
    \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-03 11:00:00');
    \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-01 11:00:00');
));

$ascComparer = DateTimeComparer();
$descComparer = DateTimeComparer(Comparer::DESC);

/**
 * array(
 *    \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-01 11:00:00');
 *    \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-02 11:00:00');
 *    \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-03 11:00:00');
 * )
 */
$collection->sort($ascComparer);

/**
 * array(
 *    \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-03 11:00:00');
 *    \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-02 11:00:00');
 *    \DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-01 11:00:00');
 * )
 */
$collection->sort($descComparer);
```


About
=====

Autore
------

Lorenzo Marzullo - <marzullo.lorenzo@gmail.com>

License
-------

DoctrineSortableCollections è rilasciato sotto la licenza MIT - vedere il file 'LICENSE' per i dettagli
