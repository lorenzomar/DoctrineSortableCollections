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
3. `CallbackComparer`, questo comparatore acc

Esempi
------

```php
use DoctrineSortableCollections\SortableArrayCollection;
use DoctrineSortableCollections\Comparer\NumericalComparer;

$collection = new SortableArrayCollection(array(3, 1, 2));
$comparer = NumericalComparer();
```


About
=====

Autore
------

Lorenzo Marzullo - <marzullo.lorenzo@gmail.com>

License
-------

DoctrineSortableCollections è rilasciato sotto la licenza MIT - vedere il file 'LICENSE' per i dettagli


Il metodo sort di SortableInterface accetta una parametro solo, un comparatore, il cui unico compito sarà quello di comparare due elementi della collezione
L'interfaccia SortableInterface definisce il metodo sort attraverso il quale la collection
