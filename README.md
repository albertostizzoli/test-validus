# TEST-VALIDUS

## SCOPO DEL TEST

Creare un modulo di invio dati da un'interfaccia e salvarli su un database.

## LINGUAGGI RICHIESTI

- HTML con il framework EXT JS( tramite CDN) per la parte di Frontend;
- PHP per la parte di Backend;
- MySQL per salvare i dati su database;

## PROCEDIMENTO

### MySQL

Ho cominciato a creando un database chiamato ```registration_db``` in cui all'interno ho implementato una tabella ```users``` con tutti i dati che servivano al progetto.

### PHP

Ho creato il file ```server.php``` che fungerà da lato Backend del Test, ho iniziato implementando la connessione al database con la classe ```mysqli``` con relativo controllo. Poi sono passato a creare le variabili che mi serviranno per il form dell'interfaccia e che verrano ricevuti tramite metodo ```$_POST``` per motivi di sicurezza. Gli obiettivi del Test sono quelli di verificare che i campi del form devono essere tutti compilati e che l'email deve essere valida, per il primo ho scritto una condizione che se anche solo uno dei campi è vuoto il form non funziona, per il secondo ho usato il metodo ```filter_var``` con il suo filtro ```FILTER_VALIDATE_EMAIL```. Infine ho inserito i dati nel database tramite una variabile ```$sql``` che contiene una stringa SQL per eseguire un'istruzione ```INSERT INTO```  e questa query ha lo scopo di inserire i dati nel database.
Infine ho fatto in modo di eseguire la query tramite una condizione che se vera (```=== TRUE```) restituirà una risposta al client in formato JSON. 
Con il metodo ```$conn->close()``` chiudo la connessione al database. 

### HTML - EXT JS

Infine sono passato alla parte di Frontend creando il file
```index.html``` e ho cominciato a studiare un nuovo framework JavaScript chiamato EXT JS che consente di scrivere un documento in HTML in modo dinamico e ho incluso la CDN del framework della versione 6.0.0.

Come detto in precedenza tutto viene scritto all'interno del tag ```script```dell'HTML:

#### Codice JavaScript per creare il form con Ext JS

```
<script type="text/javascript">
    Ext.onReady(function () {
        Ext.create('Ext.form.Panel', {
            renderTo: 'formPanel',
            scrollable: true,
            title: 'Register',
            margin: 150,
            width: 355,
            bodyPadding: 10,
```

- ```Ext.onReady```: Il codice viene eseguito quando la pagina è completamente caricata.
- ```Ext.create('Ext.form.Panel')```: Crea un pannello che contiene il form, con alcune proprietà specificate:
- ```renderTo: 'formPanel'```: Il form verrà renderizzato all'interno dell'elemento con ID formPanel presente nel body HTML.
- ```scrollable: true```: Abilita lo scorrimento nel form.
- ```title: 'Register'```: Titolo del form.
- ```margin e width```: Spaziatura e larghezza del form.
- ```bodyPadding```: Padding interno del form per separare gli elementi dai bordi.

#### Impostazioni dei campi del form

```
fieldDefaults: {
    labelAlign: "right",
    labelWidth: 115,
    msgTarget: 'side'
},
```
Questa sezione specifica i valori predefiniti per i campi del form:

- ```labelAlign```: Allinea le etichette sulla destra.
- ```labelWidth```: Imposta la larghezza delle etichette.
- ```msgTarget```: Specifica dove visualizzare i messaggi di errore di validazione (in questo caso sul lato).


#### Fieldset "User Info"
```
items: [
    {
        xtype: 'fieldset',
        title: 'User Info',
        defaultType: 'textfield',
        defaults: { anchor: '100%' },
        items: [
            {
                fieldLabel: 'User ID:',
                name: 'userId',
                emptyText: 'user id',
                allowBlank: false
            },
            ...
```
- ```fieldset```: Un gruppo logico di campi (in questo caso "User Info").
- ```xtype: 'textfield'```: Specifica che i campi saranno di tipo testo.
- ```fieldLabel```: L'etichetta mostrata per ciascun campo.
- ```name```: L'attributo name che verrà inviato al backend.
- ```emptyText```: Il testo segnaposto mostrato quando il campo è vuoto.
- ```allowBlank```: false: Indica che il campo è obbligatorio e non può essere lasciato vuoto.

#### Fieldset "Contact Information"

Simile alla sezione "User Info", ma con campi per informazioni di contatto:

```
{
    xtype: 'fieldset',
    title: 'Contact Information',
    items: [
        {
            fieldLabel: 'First Name:',
            name: 'firstName',
            allowBlank: false
        },
        ...
        {
            xtype: 'datefield',
            fieldLabel: 'Date of Birth:',
            name: 'regDate',
            format: 'Y-m-d',
            allowBlank: false
        }
    ]
}
```
I campi sono simili a quelli precedenti, ma qui viene introdotto un campo data (xtype: 'datefield') con il formato 'Y-m-d' (anno-mese-giorno).

#### Bottoni e Funzionalità di Invio

```
buttons: [
    {
        text: 'Register',
        formBind: true,
        disabled: true,
        handler: function () {
            const form = this.up('form').getForm();
            if (form.isValid()) {
                form.submit({
                    url: 'server.php',
                    method: 'POST',
                    success: function (form, action) {
                        Ext.Msg.alert('Successo', action.result.message);
                    },
                    failure: function (form, action) {
                        Ext.Msg.alert('Errore', action.result ? action.result.message : 'I dati non sono stati inseriti');
                    }
                });
            }
        }
    }
]
```
- ```formBind: true```: Abilita il pulsante solo se il form è valido (tutti i campi obbligatori sono compilati correttamente).
- ```handler```: Definisce l'azione da eseguire quando il pulsante viene cliccato.
- ```form.submit()```: Invia il form al server (```server.php```) usando il metodo POST.
- ```success e failure```: Definiscono le azioni da compiere in caso di successo o fallimento della richiesta, mostrando un messaggio popup tramite ```Ext.Msg.alert.```

#### Sezione Body

```
<body>
    <div class="d-flex justify-content-center align-items-center">
        <div id="formPanel"></div>
    </div>
</body>
```

Questa parte crea un contenitore con classi Bootstrap per centrare il form verticalmente e orizzontalmente sulla pagina. Il form verrà renderizzato all'interno del div con ID ```formPanel```.