DoctrineSortableCollections
=============================

Questa libreria estende la libreria base di Doctrine aggiungendo funzionalità di ordinamento delle collections.

## Installation
DoctrineSortableCollections può essere facilmente installato usando composer
```php
composer require lorenzomar/doctrine-sortable-collections
```
oppure aggiungendolo al file composer.json



Il metodo sort di SortableInterface accetta una parametro solo, un comparatore, il cui unico compito sarà quello di comparare due elementi della collezione
L'interfaccia SortableInterface definisce il metodo sort attraverso il quale la collection
