Come funzionano i cataloghi
==

Un catalogo è una collezione di aree che coprono una specifica porzione di territorio, le aree sono caratterizzate da un codice che specifica il tipo di intervento di servizio ECOSISTEMICO e relativo prezzo per unità di superficie oltre alla variazione dello stesso in funzione dei valori di pendenza e di distanza di trasporto imposto.

Nel caso del progetto MIPAAF per la comunità di bosco si è seguita la seguente classificazione:

**Prima parte del codice:**  

| Intervento | Codice |
| -----------|--------|
| Nessuna lavorazione | 0 |
| Diradamento | 1 |
| Taglio ceduo | 2 |
| Avviamento | 3 |

**Seconda parte del codice:**  
| Classe di Pendenza | Codice |
| -----------|--------|
| I Classe di Pendenza | A |
| II Classe di Pendenza | B |
| II Classe di Pendenza | C |

**Terza parte del codice:**  
| Distanza traposto imposto | Codice |
| -----------|--------|
| trasporto imposto < 500 m | A |
| trasporto imposto 500-1000 m | A |
| trasporto imposto > 1000 m | A |

Per importare un nuovo catalogo utilizzare il comando artisan:

```sh
> php artisan sisteco:import_catalog path
```

Usare l'opzione --help per avere informazioni dettagliate sul funzionamento del comando.

L'opzione path indica una directory che contiene due file:
* prezzario.xls
* areas.geojson

Per un esempio visionare la cartella /storage/catalogs/mipaaf  

Il file **prezzario.xls** ha la seguente struttura:

|N. INTERVENTO | PENDENZA | TRASPORTO |	CODICE |	 PREZZO |
| ---- | ---- | ---- | ---- | ----- |
| 1	| A	| 1	| 1.A.1	|  12.814,20 € |
| 1	| A	| 2	| 1.A.2	|  12.981,38 € |
| 1	| A	| 3	| 1.A.3	|  13.148,56 € |
| ...| ...	| ...	| ...	|  .... |

Nel caso del progetto MIPAAF le voci totali sono 27 alle quali va aggiunto la voce relativa a nessun intervento: viene fatto automaticamente dallo script di importazione quindi non deve essere presente nel file prezzario.xls

Il file **areas.geojson** è un file geojson che contiene la geometria di tutte le aree del catalogo con la proprietà "COD_INT" che richiama il codice intervento. I valori di pendenza e di trasporto vengono invece calcolati dal sistema a partire dalla particella catastale.

Stima del valore ecosistemico di una particella catastale
==

La stima del valore ecosistemico di una particella catastale viene effettuata con il comando

```sh
> php artisan sisteco:estimate_by_catalog [id]
```

Lo script esegue un ciclo su tutte le particelle che sono associate ad almeno un proprietario (Owner) e per ciascuna particella calcola la stima considerando classe di pendenza e di trasporto. Il risultato viene salvato in un opportuno campo della particella denominato "catalog_estimate" sotto forma di array (un item per ciascun tipo di intervento):

```php
    $catalog_estimate = [
        "items" => [
            $item1,
            $item2,
            ...
            $itemN
        ],
        "value" => somma di tutti i price dei vari items
    ];
    $item[]=[
        'code' => COD_INT,
        'area' => area totale di tipo COD_INT nella particella catastale,
        'unit_price' => prezzo unitario in base alle classi di pendenza e area,
        'price' => area * $price[$item->catalog_type_id],
    ];
```

