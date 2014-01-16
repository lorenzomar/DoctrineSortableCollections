DoctrineSortableCollections
=============================

DoctrineSortableCollections è una libreria che aggiunge alla libreria base di Doctrine funzionalità di ordinamento.
Grazie a DoctrineSortableCollections sarà possibile ordinare liste semplici (composte cioè da numeri, stringhe, date, ecc) o complesse (ad sempio liste contenenti oggetti che si desidera ordinare sulla base dei valori di una o più proprietà, oppure array di array) sfruttando il componente `PropertyAccess` di Symfony.

Installazione
-------------

DoctrineSortableCollections può essere installata usando composer

```
composer require lorenzomar/doctrine-sortable-collections
```

oppure aggiungendola al file composer.json

```
"require": {
    "lorenzomar/doctrine-sortable-collections": "dev-master"
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
Per eseguire ordinamenti su liste complesse, passare a `Comparer` un'istanza di `PropertyAccessorInterface` e `PropertyPathInterface` grazie ai quali il comparatore potrà accedere ai dati necessari per eseguire il confronto. ([qui](http://symfony.com/doc/current/components/property_access/index.html) si può consultare la documentazione di `PropertyAccess`).

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
    $res = strcmp($e1, $e2);

    if ($res < 0) {
        return ($collection->isAsc()) ? $res : 1;
    } elseif ($res === 0) {
        return $res;
    } else {
        return ($collection->isAsc()) ? $res : -1;
    }
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

Ordinare liste complesse
------------------------

Come detto in precedenza, l'ordinamento di liste complesse sfrutta il componente `PropertyAccess` di Symfony. Quello che segue è un esempio di una lista in cui ogni elemento è a sua volta un array contenente informazioni su un ipotetico utente; si vuole ordinare la lista sulla base di alcune proprietà dell'utente.

```php
use DoctrineSortableCollections\SortableArrayCollection;
use DoctrineSortableCollections\Comparer\DateTimeComparer;
use DoctrineSortableCollections\Comparer\NumericalComparer;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\PropertyAccess\PropertyAccess;

$users = array(
    array(
        'firstName' => 'First name 1',
        'lastName'  => 'Last name 1',
        'age'       => 22,
        'birthDate' => \DateTime::createFromFormat('Y-m-d H:i:s', '1988-07-30 00:00:01')
    ),
    array(
        'firstName' => 'First name 2',
        'lastName'  => 'Last name 2',
        'age'       => 17,
        'birthDate' => \DateTime::createFromFormat('Y-m-d H:i:s', '1992-01-06 14:54:23')
    ),
    array(
        'firstName' => 'First name 3',
        'lastName'  => 'Last name 3',
        'age'       => 56,
        'birthDate' => \DateTime::createFromFormat('Y-m-d H:i:s', '1958-03-19 22:00:00')
    ),
    array(
        'firstName' => 'First name 4',
        'lastName'  => 'Last name 4',
        'age'       => 30,
        'birthDate' => \DateTime::createFromFormat('Y-m-d H:i:s', '1977-11-30 10:45:00')
    ),
    array(
        'firstName' => 'First name 5',
        'lastName'  => 'Last name 5',
        'age'       => 11,
        'birthDate' => \DateTime::createFromFormat('Y-m-d H:i:s', '2000-10-13 15:35:01')
    )
);

$collection = new SortableArrayCollection($users);

$propertyAccessor = PropertyAccess::createPropertyAccessor();

// Ordina la lista sulla base del campo 'age'
$propertyPath = new PropertyPath('[age]');
$comparer = new NumericalComparer();
$comparer->setPropertyAccessor($propertyAccessor);
$comparer->setPropertyPath($propertyPath);

$collection->sort($comparer);

// Ordina la lista sulla base del campo 'birthDate'
$propertyPath = new PropertyPath('[birthDate]');
$comparer = new DateTimeComparer();
$comparer->setPropertyAccessor($propertyAccessor);
$comparer->setPropertyPath($propertyPath);

$collection->sort($comparer);
```

About
=====

Autore
------

Lorenzo Marzullo - <marzullo.lorenzo@gmail.com>

License
-------

DoctrineSortableCollections è rilasciata sotto licenza MIT - vedere il file 'LICENSE' per i dettagli
