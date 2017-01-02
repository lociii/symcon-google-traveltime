# Google traveltime
Die Fahrzeit zwischen zwei Adressen und die Verzoegerung zur regulaeren Fahrzeit koennen als Variablen abgelegt werden

### Inhaltverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Einrichten der Instanzen in IP-Symcon](#2-einrichten-der-instanzen-in-ip-symcon)
3. [PHP-Befehlsreferenz](#3-php-befehlsreferenz)

### 1. Funktionsumfang

* Reisezeit (PKW) zwischen zwei Orten als Variable ablegen
* Verzoegerung zur regulaeren Reisezeit (PKW) zwischen zwei Orten als Variable ablegen

### 2. Einrichten der Instanzen in IP-Symcon

* Unter 'Instanz hinzufuegen das 'GoogleDistanceTraveltime'-Modul des Herstellers 'LociSymcon' auswaehlen und eine neue Instanz erzeugen.
* Google API Key erzeugen und eintragen (Google Distance Matrix API muss freigeschaltet sein)
* Start und Zieladresse eintragen (Format kann in Google Maps geprueft werden)
* Aktualisierungsinterval waehlen (Kostenfrei sind 2500 Abrufe je Tag in der Google Distance Matrix API - das Intervall sollte also auf maximal 2 Minuten reduziert werden, wenn nur eine Instanz aktiv ist)

### 3. PHP-Befehlsreferenz

`LOCIGDT_Update();`
Aktualisiert die Werte der Instanz
