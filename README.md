DoctrineSortableCollections
=============================

DoctrineSortableCollections è una libreria che aggiunge alla libreria base di Doctrine funzionalità di ordinamento.
Grazie a DoctrineSortableCollections sarà possibile ordinare liste semplici (composte cioè da numeri, stringhe, date, ecc) o complesse (ad sempio liste contenenti oggetti che si desidera ordinare sulla base dei valori di una o più proprietà, oppure array di array) sfruttando la libreria `PropertyAccess` di Symfony.

Installazione
-------------

DoctrineSortableCollections può essere installata usando composer

```
composer require lorenzomar/doctrine-sortable-collections
```

oppure aggiungendola al file composer.json

```
require: {
    "lorenzomar/doctrine-sortable-collections"
}
```

Utilizzo
--------

Alla base di tutto c'è `SortableArrayCollection` che estende `ArrayCollection` e implementa `SortableInterface` aggiungendo un metodo `sort` grazie al quale sarà possibile ordinare la collection. L'unico parametro richiesto da `sort` è un'istanza di `ComparerInterface`.

I comparatori sono oggetti il cui unico compito è quello di confrontare due elementi e ritornare:
* -1 nel caso in cui il primo elemento > del secondo
* 0 nel caso in cui i due elementi siano identici
* 1 nel caso in cui il primo elemento < del secondo

Attualmente sono presenti 3 comparatori:

1. `NumericalComparer`, in grado di confrontare due valori numerici di qualsiasi formato (interi, float, esadecimali, binari, ottali)
2. `DateTimeComparer`, in grado di confrontare due oggetti `DateTime`
3. `CallbackComparer`, questo è il più generico di tutti. Confronta due elementi sfruttando una callback che gli viene fornita dall'utente. In caso nessun altro comparatore risulti adatto, si può ripiegare su questo

La libreria offre una classe base per i comparatori, `Comparer`, che implementa la possibilità di scegliere il verso dell'ordinamento (ascendente o discendente). Di default ascendente, ma è possibile passare il verso al `__construct` oppure usando il metodo `setDirection`.
Per eseguire ordinamenti su liste complesse, passare a `Comparer` un'istanza di `PropertyAccessorInterface` e `PropertyPathInterface` grazie ai quali il comparatore potrà accedere ai dati necessari per eseguire il confronto. ([qui](http://symfony.com/doc/current/components/property_access/index.html) si può consultare la documentazione di `PropertyAccess`)
`Comparer` offre anche le funzionalità base per gestire la libreria `PropertyAccess`.

Ordinare liste semplici
-----------------------

Negli esempi che seguono si vedrà come ordinare delle liste composte da elementi semplici (numeri, date, stringhe).

Questo esempio mostra come ordinare una lista di numeri grazie a `NumericalComparer`

```php
use DoctrineSortableCollections\SortableArrayCollection;
use DoctrineSortableCollections\Comparer\Comparer;
use DoctrineSortableCollections\Comparer\NumericalComparer;

$collection = new SortableArrayCollection(array(3, 1, 2));
$ascComparer = new NumericalComparer();
$descComparer = new NumericalComparer(Comparer::DESC);

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

$ascComparer = new DateTimeComparer();
$descComparer = new DateTimeComparer(Comparer::DESC);

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

Questo esempio mostra come ordinare una lista di stringhe sfruttando `CallbackComparer`

```php
use DoctrineSortableCollections\SortableArrayCollection;
use DoctrineSortableCollections\Comparer\Comparer;
use DoctrineSortableCollections\Comparer\CallbackComparer;

$collection = new SortableArrayCollection(array(
    'stringa 2',
    'stringa 1',
    'stringa 3'
));

$callback = function($e1, $e2, $collection) {
};
$ascComparer = new CallbackComparer($callback);
$descComparer = new CallbackComparer($callback, Comparer::DESC);

/**
 * array(
 *    'stringa 1',
 *    'stringa 2',
 *    'stringa 3'
 * )
 */
$collection->sort($ascComparer);

/**
 * array(
 *    'stringa 3',
 *    'stringa 2',
 *    'stringa 1'
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

DoctrineSortableCollections è rilasciata sotto licenza MIT - vedere il file 'LICENSE' per i dettagli
