C:\Users\neo\Desktop\Prueba>sqlite3 database.db
sqlite> .mode csv
sqlite> .import C:/route/file.csv tbl
sqlite> .schema tbl

PASOS A SEGUIR PARA LA IMPORTACIÓN DE DATOS EN UNA BASE DE DATOS SQLITE EN DETALLE

Con DB browser for SQLlite
Crear una base de datos con extensión .sqlite or .db etc.

Ahora crearemos la tabla pais.
CREATE TABLE "pais" (
	"id_pais"	INTEGER NOT NULL,
	"nombre"	TEXT NOT NULL,
	"codigo_alfa_2"	TEXT NOT NULL,
	"codigo_alfa_3"	TEXT NOT NULL,
	"codigo_numerico"	TEXT NOT NULL,
	PRIMARY KEY("id_pais" AUTOINCREMENT)
);

Luego por consola abrimos la base de datos creada anteriormente con DB browser for SQLlite, con el siguiente comando.
sqlite3 nombreBaseDeDatos.sqlite, para poder realizar esta acción es necesario descargar SQLite en el siguiente enlace https://www.sqlite.org/download.html, para poder acceder a la herramienta desde cualquier ubicación en windows es necesario setear la variable de entorno del sistema y que apunte al archivo sqlite.exe que hemos descargado.
Una vez dentro de la base de datos activamos el modo csv para importar datos desde un archivo .csv, en este caso el archivo de paises, de la siguiente forma.
.mode csv
El paso siguiente es importar el archivo csv ubicando la ruta y seleccionar la tabla donde queremos importar los datos.
.import C:/Users/neo/Desktop/test-import-csv-sqlite/pais-utf-8.csv pais

PD: el archivo excel puede ser modificado a gusto, para generar el archivo .csv es necesario despues de editar el archivo excel, guardarlo como archivo .csv UTF-8 delimitado por comas, esto generará el .csv, pero los datos no estarán delimitados por comas, los datos estarán delimitados por punto y coma (;), lo siguiente es con algún editor de código sublime, VS o el bloc de notas, utilizar el search and replace para reemplazar los puntos y comas (;) por (,), aunque esto creo que no hace falta en este contexto.
Aquí hay que tener en cuenta los campos que dentro ya cotengan comas (,). Deberemos ubicarlos y encerrarlos entre comillas dobles, por ejemplo el registro 28 y el 204:
28,"Bonaire, San Eustaquio y Saba",BQ,BES,535
204,"Santa Elena, Ascensión y Tristán de Acuña",SH,SHN,654