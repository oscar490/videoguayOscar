------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
      id       BIGSERIAL PRIMARY KEY
    , nombre   VARCHAR(255) NOT NULL UNIQUE
    , password VARCHAR(255) NOT NULL
    , email    VARCHAR(255)
);

CREATE INDEX idx_usurios_email ON usuarios (email);

DROP TABLE IF EXISTS socios CASCADE;

CREATE TABLE socios
(
    id        BIGSERIAL    PRIMARY KEY
  , numero    NUMERIC(6)   NOT NULL UNIQUE
  , nombre    VARCHAR(255) NOT NULL
  , direccion VARCHAR(255) NOT NULL
  , telefono  NUMERIC(9)   CONSTRAINT ck_telefono_no_negativo
                           CHECK (telefono IS NULL OR telefono >= 0)
);

CREATE INDEX idx_socios_nombre ON socios (nombre);
CREATE INDEX idx_socios_telefono ON socios (telefono);


DROP TABLE IF EXISTS peliculas CASCADE;

CREATE TABLE peliculas
(
    id         BIGSERIAL    PRIMARY KEY
  , codigo     NUMERIC(4)   NOT NULL UNIQUE
  , titulo     VARCHAR(255) NOT NULL
  , precio_alq NUMERIC(5,2) NOT NULL
);

CREATE INDEX idx_peliculas_titulo ON peliculas (titulo);


DROP TABLE IF EXISTS alquileres CASCADE;

CREATE TABLE alquileres
(
    id          BIGSERIAL    PRIMARY KEY
  , socio_id    BIGINT       NOT NULL REFERENCES socios (id)
                             ON DELETE NO ACTION ON UPDATE CASCADE
  , pelicula_id BIGINT       NOT NULL REFERENCES peliculas (id)
                             ON DELETE NO ACTION ON UPDATE CASCADE
  , create_at   TIMESTAMP(0) NOT NULL DEFAULT current_timestamp
  , devolucion  TIMESTAMP(0)
  , UNIQUE (socio_id, pelicula_id, create_at)

);

CREATE INDEX idx_alquileres_pelicula_id ON alquileres (pelicula_id);
CREATE INDEX idx_alquileres_created_at ON alquileres (create_at DESC);


INSERT INTO socios (numero, nombre, direccion, telefono)
     VALUES (100, 'Pepe', 'Su casa', 956956956),
            (200, 'Juan', 'Su hogar', 876543567),
            (300, 'María', 'Su calle', 766543345);

INSERT INTO peliculas (codigo, titulo, precio_alq)
    VALUES  (1000, 'Los últimos jedi', 5),
            (2000, 'La amenaza fantasma', 4),
            (3000, 'El ataque de los clones', 3);

INSERT INTO alquileres (socio_id, pelicula_id, create_at, devolucion)
    VALUES  (1, 1, current_timestamp - 'P4D'::interval, current_timestamp - 'P3D'::interval),
            (1, 2, current_timestamp - 'P2D'::interval, null),
            (1, 3, current_timestamp - 'P1D'::interval, current_timestamp),
            (3, 1, current_timestamp - 'P3D'::interval, current_timestamp - 'P1D'::interval);


INSERT INTO usuarios (nombre, password, email)
    VALUES ('pepe', crypt('pepe', gen_salt('bf', 13)), 'pepe@pepe.com')
         , ('juan', crypt('juan', gen_salt('bf', 13)), 'juan@juan.com');
