USUARIO	
id_usuario	
apellido	
nombre	
num_documento	
email	
password	
perfil      ENUM(admin/usuario) DEFAULT 'usuario'
sexo	
created	
last_modified	
deleted   TINYINT(1) activo/inactivo


CREATE TABLE pet (name VARCHAR(20), owner VARCHAR(20),
       species VARCHAR(20), sex CHAR(1), birth DATE, death DATE);

Calcular la edad a partir de la fecha de cumpleaños
https://dev.mysql.com/doc/mysql-tutorial-excerpt/8.0/en/date-calculations.html

https://dev.mysql.com/doc/mysql-getting-started/en/
Para ingresar a mysql por consola
>mysql -u root -p
LOAD DATA LOCAL INFILE 'C:/xampp/htdocs/domicilio/data.txt' INTO TABLE pet;
Para archivos editados con el bloc de notas en windows, valores separados por tabulador( tsv )
Si creó el archivo en Windows con un editor que usa \r\n como terminador de línea, debe usar esta declaración en su lugar:
LOAD DATA LOCAL INFILE 'C:/xampp/htdocs/domicilio/data.txt' INTO TABLE pet LINES TERMINATED BY '\r\n';   


mysql> SELECT name, birth, CURDATE(),
       TIMESTAMPDIFF(YEAR,birth,CURDATE()) AS age
       FROM pet;
+----------+------------+------------+------+
| name     | birth      | CURDATE()  | age  |
+----------+------------+------------+------+
| Fluffy   | 1993-02-04 | 2003-08-19 |   10 |
| Claws    | 1994-03-17 | 2003-08-19 |    9 |
| Buffy    | 1989-05-13 | 2003-08-19 |   14 |
| Fang     | 1990-08-27 | 2003-08-19 |   12 |
| Bowser   | 1989-08-31 | 2003-08-19 |   13 |
| Chirpy   | 1998-09-11 | 2003-08-19 |    4 |
| Whistler | 1997-12-09 | 2003-08-19 |    5 |
| Slim     | 1996-04-29 | 2003-08-19 |    7 |
| Puffball | 1999-03-30 | 2003-08-19 |    4 |
+----------+------------+------------+------+

NOTA:
Ejemplo 1, NOT NULL
CREATE TABLE test(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL UNIQUE
) ENGINE = INNODB CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

NOT NULL, significa que la columna no puede ser nula. La siguiente sentencia generará un error.
INSERT INTO test (email) VALUES(NULL); // la columna email no puede contener la palabra NULL (ser nula)
Sin embargo, la siguiente declaración es válida.
INSERT INTO test (email) VALUES('');
Pero, no podremos insertar dos veces un caracter vacío ('') por ser el campo UNIQUE

Ejemplo 2, NULL
CREATE TABLE test(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NULL UNIQUE
) ENGINE = INNODB CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

NULL, significa que la columna puede ser nula. La siguiente sentencia NO generará un error.
INSERT INTO test (email) VALUES(NULL); // la columna email puede contener la palabra NULL.
La siguiente declaración también es válida.
INSERT INTO test (email) VALUES('');
Pero, no podremos insertar dos veces un caracter vacío ('') por ser el campo UNIQUE

Ejemplo 3, se comporta igual que el ejemplo 2
CREATE TABLE test(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) UNIQUE
) ENGINE = INNODB CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

NULL, significa que la columna puede ser nula. La siguiente sentencia NO generará un error.
INSERT INTO test (email) VALUES(NULL); // la columna email puede contener la palabra NULL.
la siguiente declaración también es válida.
INSERT INTO test (email) VALUES('');
Pero, no podremos insertar dos veces un caracter vacío ('') por ser el campo UNIQUE

CONCLUSIÓN:
Si un campo es UNIQUE y no es obligatorio, por ejemplo en MySQL:
email VARCHAR(50) NULL UNIQUE o email VARCHAR(50) UNIQUE
Entonces si no tenemos el correo electrónico, deberemos registrar el campo como NULL,
para no generar un error de campos duplicados, ya que el campo es UNIQUE.

CONSIDERACIONES ACERCA DE LA VALIDACIóN DE UN NúMERO ENTERO POSITIVO.
Antes de consultar a la base de datos se validaba que el id fuese un número entero positivo.
por ejemplo:

SELECT * FROM asociado WHERE id_asociado = 3;
El 3 es un número entero positivo, de hecho todos los ids son números enteros positivos mayores a cero. También el campo id_asociado
en la tabla asociado fue definido como entero. (Data Definition Language, DDL por sus siglas en inglés) lenguaje de definición de datos.

Despues de algunas pruebas, casi no es necesario hacer la validación de un entero.
Si en el momento de consultar a la base de datos enviamos un valor para el campo id_asociado por ejemplo:

SELECT * FROM asociado WHERE id_asociado = '/*/*mmm';

Devolverá vacío, pero no generará un error. Con lo cual hasta el momento no veo la necesidad de validar si
el id_asociado contiene un número entero positivo mayor a cero.
A menos que solo me conecte a la base de datos si y solo si existe un número entero positivo mayor a cero.

CONCLUSIÓN:
Conectarse y consultar una base de datos es una operación costosa, así que solo accederemos a ella, sí y solo sí el/los ids son
números enteros positivos, o los campos de consulta son valores válidos. Con lo cual deberemos validar que los campos de
consulta, en este caso ids, sean minimamente caracteres numéricos positivos mayores a cero.

Ordinales
https://www.rae.es/dpd/ordinales

Info secciones de Mendoza
http://www.mendoza.edu.ar/20-de-diciembre-qdia-del-departamento-de-capitalq/
http://www.mendoza.edu.ar/wp-content/uploads/2011/10/1_CAPITAL_-2016.png

El codigo ASCII
https://elcodigoascii.com.ar/codigos-ascii-extendidos/signo-ordinal-femenino-genero-codigo-ascii-166.html
codigo ascii 166 = ª ( Ordinal femenino, indicador de genero femenino ) => (ª alt + 166 ) undécima
( entidad HTML = &ordf; )
codigo ascii 167 = º ( Ordinal masculino, indicador de genero masculino ) => (º alt + 167 ) undécimo
codigo ascii 248 = ° ( Signo de grado, anillo ) => (° alt + 248 )

vocales con diéresis
ä alt + 132
ë alt + 137
ï alt + 139
ö alt + 148
ü alt + 129

Ä alt + 142
Ë alt + 211
Ï alt + 216
Ö alt + 153
Ü alt + 154

INFORMACIÓN ACERCA DE LAS LOCALIDADES DE LA BASE DE DATOS
22826 localidades, última actualización 24/09/2020 10:30

// $a = 1;
// $b = !!$a;
// var_dump( ~$a ); -2
// var_dump( $b ); true

C:/xampp/htdocs/domicilio/datos/paises-utf8.csv

Listado de abreviaturas utilizadas (INDEC) ejemplo manzana => manz.
https://geoservicios.indec.gov.ar/nomenclador-vias-de-circulacion/archivos/NNVC_abreviaturas.pdf

Normas generales para el uso de abreviaturas en el Instituto Geográfico Nacional
https://www.ign.gob.ar/archivos/cartografia/normas_generales_abreviaturas.pdf

Orientaciones acerca del domicilio
https://www.santafe.gob.ar/index.php/web/content/download/248608/1307349/version/2/file/MMUVRA+-+Manual+del+Listador++2015+Final+-18+-3.pdf

<!-- Fecha de nacimiento select para día, mes, año -->
            <div class="col-sm-3 mb-3">
                <label>Fecha de nacimiento *</label>

                <div class="form-row">
                    <!-- Día del mes, 2 dígitos sin ceros iniciales: 'j' => 1 a 31 -->
                    <div class="col-md-4">
                        <select name="asociado[birthday_day]" id="birthday-day"
                            class="custom-select custom-select-lg <?= isset( $errors['fecha_nacimiento'] ) ? 'is-invalid' : ''; ?>">
                            <option value="0">Día</option>
                            <?php for($dia = 1; $dia <= 31; $dia++): ?>
                            <option value="<?= $dia; ?>"
                                <?php if ($asociado->getFechaNacimiento() && $dia == $asociado->getFechaNacimiento()->format('j')): ?>
                                selected
                                <?php endif; ?>
                                ><?= $dia; ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="invalid-feedback"><?php echo $errors['fecha_nacimiento'] ?? ''; ?></div>
                    </div>
                    <!-- Representación numérica de un mes, sin ceros iniciales: 'n' => 1 a 12 -->
                    <div class="col-md-4">
                        <select name="asociado[birthday_month]" id="birthday-month"
                            class="custom-select custom-select-lg <?= isset( $errors['fecha_nacimiento'] ) ? 'is-invalid' : ''; ?>">
                            <option value="0">Mes</option>
                            <?php
                            $meses = [1 => 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
                            for($mes = 1; $mes <= 12; $mes++): ?>
                            <option value="<?= $mes; ?>"
                            <?php if ($asociado->getFechaNacimiento() && $mes == $asociado->getFechaNacimiento()->format('n')): ?>selected
                            <?php endif; ?>
                            ><?= $meses[$mes]; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <!-- Una representación numérica completa de un año, 4 dígitos: 'Y' => ejm: 1999 o 2003 -->
                    <div class="col-md-4">
                        <select name="asociado[birthday_year]" id="birthday-year"
                            class="custom-select custom-select-lg <?= isset( $errors['fecha_nacimiento'] ) ? 'is-invalid' : ''; ?>">
                            <option value="0">Año</option>
                            <?php
                            $anioActual = date('Y');
                            for($anio = $anioActual; $anio >= 1905; $anio--): ?>
                            <option value="<?= $anio; ?>"
                            <?php if ($asociado->getFechaNacimiento() && $anio == $asociado->getFechaNacimiento()->format('Y')): ?>
                                selected <?php endif; ?>
                            ><?= $anio; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <!-- <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;"></div> -->

            </div>