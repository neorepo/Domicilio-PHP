CREATE TABLE "pais" (
	"id_pais"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"nombre"	TEXT NOT NULL,
	"codigo_alfa_2"	TEXT NOT NULL,
	"codigo_alfa_3"	TEXT NOT NULL,
	"codigo_numerico"	TEXT NOT NULL
);

CREATE TABLE "provincia" (
	"id_provincia"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"nombre"	TEXT NOT NULL,
	"codigo_3166_2"	TEXT NOT NULL UNIQUE,
	"id_pais"	INTEGER NOT NULL,
	FOREIGN KEY("id_pais") REFERENCES "pais"("id_pais")
);

CREATE TABLE "localidad" (
	"id_localidad"	INTEGER NOT NULL PRIMARY KEY,
	"nombre"	TEXT NOT NULL,
	"codigo_postal"	TEXT NOT NULL,
	"id_provincia"	INTEGER NOT NULL,
	FOREIGN KEY("id_provincia") REFERENCES "provincia"("id_provincia")
);
CREATE INDEX idx_localidad_id_provincia ON localidad(nombre, id_provincia);

CREATE TABLE "domicilio" (
	"id_domicilio"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"calle"	TEXT,
	"numero"	TEXT,
	"piso"	TEXT,
	"departamento"	TEXT,
	"barrio"	TEXT,
	"id_localidad"	INTEGER NOT NULL,
	"created" DATETIME NOT NULL,
	"last_modified" DATETIME NOT NULL,
    "deleted" INTEGER NOT NULL DEFAULT 0 CHECK("deleted" IN(0, 1)),
	FOREIGN KEY("id_localidad") REFERENCES "localidad"("id_localidad")
);