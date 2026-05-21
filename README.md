# Laureandosi 2.0 - Gestione Prospetti di Laurea

## Indice
* [Descrizione del progetto](#descrizione-del-progetto)
* [Funzionalità principali](#funzionalità-principali)
* [Tecnologie utilizzate](#tecnologie-utilizzate)
* [Struttura del progetto](#struttura-del-progetto)
* [Installazione](#installazione)
* [Utilizzo](#utilizzo)
* [Collaudo e Test](#collaudo-e-test)
* [Ingegneria del Software e Documentazione](#ingegneria-del-software-e-documentazione)

## Descrizione del Progetto
Laureandosi 2.0 è un'applicazione web sviluppata per automatizzare la generazione e l'invio dei prospetti di laurea. Il sistema preleva i dati delle carriere degli studenti, calcola le medie pesate applicando le specifiche formule di ciascun corso di laurea, e genera documenti PDF destinati sia alla commissione esaminatrice che ai singoli laureandi.

## Funzionalità Principali
* **Generazione di PDF dinamici:** Creazione di due tipologie di prospetti. Uno riassuntivo per la commissione (con la lista completa dei candidati) e uno dettagliato per lo studente (con dati anagrafici, esami, formula applicata e simulazione del voto).
* **Calcolo della media:** Calcolo automatico della media pesata e dei crediti, con applicazione di formule di laurea personalizzabili. Include la gestione dinamica di regole specifiche, come il calcolo del bonus laurea per il corso di Ingegneria Informatica.
* **Invio delle e-mail automatico:** Distribuzione automatizzata dei prospetti agli studenti tramite e-mail temporizzate (batch con invio ogni 5 secondi per prevenire il sovraccarico del server SMTP).
* **Pannello di configurazione:** Gestione dei parametri, delle formule di laurea e dei filtri per gli esami (es. esclusione di esami sovrannumerari o che non fanno media) modificabili tramite file JSON e un'interfaccia dedicata.

## Tecnologie utilizzate
* **Backend:** PHP 
* **Persistenza e Configurazione:** JSON
* **Librerie di Terze Parti:**
  * **FPDF:** per la generazione procedurale dei documenti.
  * **PHPMailer:** per la gestione del protocollo SMTP e l'invio sicuro delle e-mail con allegati.

## Struttura del Progetto
Il repository è organizzato modularmente per separare la logica di business dall'interfaccia:

```bash
/
├── prospetti/          # contiene i prospetti generati               
├── prospetti_test/     # contiene i prospetti corretti per verificare la correttezza dele operazioni
├── request/            # contiene i file delle richieste
├── lib/                # librerie utilizzate
├── classi/             # classi del progetto
├── configurazione/     # JSON di configurazione
├── dati/               # JSON dei dati mockup per i test
├── docs/               # Intera documentazione
├── config.php          # pagina per la configurazione
├── test.php            # pagina dei test automatizzati
├── index.php           # pagina principale del progetto
└── README.md

```

## Installazione
L'applicazione è progettata per essere eseguita su un server web standard con supporto PHP.
1. Configurare un ambiente server locale (es. utilizzando *Local by Flywheel*, XAMPP, o un container Docker).
2. Clonare il repository o copiare il contenuto della cartella del progetto all'interno della root del server (es. la directory `/app/public` in *Local*).
3. Avviare il server web e accedere all'indirizzo `http://laureandosi.local` (o `localhost`) dal browser.

## Utilizzo
Dall'interfaccia principale (`index.php`):
1. Selezionare il Corso di Laurea (CdL) dal menu a tendina e indicare la data della sessione di laurea.
2. Inserire le matricole degli studenti da elaborare nell'apposita area di testo (separate da virgola o spazio).
3. Cliccare su **Crea Prospetti** per avviare il motore di calcolo e generare i PDF.
4. Utilizzare **Apri Prospetti** per visualizzare l'anteprima del documento per la commissione, oppure **Invia Prospetti** per avviare l'invio automatizzato delle e-mail agli studenti.

## Collaudo e Test
Il sistema include una pagina di unit testing per verificare l'integrità dei calcoli e delle logiche di backend. 
* E' possibile accedere al modulo di collaudo tramite il pulsante "Test" in basso a destra nell'interfaccia che appare andandoci col cursore, o direttamente tramite `test.php`, verranno eseguiti script automatizzati sui dati mock per verificare: correttezza del calcolo della media, conteggio dei crediti, validazione delle formule, applicazione dei filtri e generazione dei PDF.

## Ingegneria del Software e Documentazione

La progettazione del software ha seguito questi passaggi:
1. Requisiti
2. Analisi
3. Progettazione
4. Implementazione
5. Tests

E' possibile vedere le scelte progettuali effettuate e un manuale d'uso sia per l'utente che per l'amministratore all'interno della [documentazione](docs/documentazione.pdf).