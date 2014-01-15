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

Il funzionamento è semplice.
`SortableArrayCollection` estende `ArrayCollection` aggiungendo un metodo sort grazie al quale sarà possibile ordinare la collection. L'unico parametro richiesto da `sort` è un'istanza di un "comparatore".
I comparatori sono oggetti il cui unico compito è quello di comparare due elementi della collection e ritornare:
* -1 se il primo elemento > del secondo
* 0 se i due elementi sono identici
* 1 se il primo elemento < del secondo

L'interfaccia `SortableInterface` definisce un metodo `sort` grazie al quale la collection verrà ordinata. `sort` richiede che gli venga passata un'istanza di `Comparer`  che come unico parametro accetta un `Comparer`.

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
