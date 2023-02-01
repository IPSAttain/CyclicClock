# CyclicClock

### 1. Funktionsumfang

Wechselt den Zustand einer bool Variablen in einer einstellbaren Taktrate.

### 2. Vorraussetzungen

- IP-Symcon ab Version 6.2

### 3. Software-Installation

* Über den Module Store das 'CyclicClock / Takgeber'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen:
https://github.com/IPSAttain/CyclicClock

### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'Takgeber'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

### 5. Statusvariablen und Profile

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

#### Statusvariablen

Name   | Typ     | Beschreibung
------ | ------- | ------------
Taktgeber | bool | Variable die im Takt umgeschaltet wird
Aktiv  | bool    | Aktiviert den Prozess
Takte/Min | integer | Taktrate
Takte/Stunde | integer | Taktrate

### 6. WebFront

Die Taktfrequenz kann in "Takte pro Minute" oder "Takte pro Stunde" über die Integer Variablen eingestellt werden.
Mit "Aktiv" kann der Prozess gesartet und gestoppt werden.

### 7. PHP-Befehlsreferenz

keine