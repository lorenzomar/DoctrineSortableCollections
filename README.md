DoctrineSortableCollections
=============================

Questa libreria estende la libreria base di Doctrine aggiungendo funzionalità di ordinamento alle collections.

Installazione
-------------

DoctrineSortableCollections può essere facilmente installata usando composer

```
composer require lorenzomar/doctrine-sortable-collections
```

oppure aggiungendola al file composer.json

Utilizzo
--------

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
