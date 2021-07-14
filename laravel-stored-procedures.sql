DELIMITER //
CREATE PROCEDURE spInsertarUsuario
( 
	IN _nombre 	VARCHAR(100),
    IN _correo 	VARCHAR(50),
    IN _pass 	VARCHAR(50)
)
BEGIN
	INSERT INTO users (nombre, correo, pass)  VALUES
	(_nombre, _correo, _pass);
END//
DELIMITER ;



DELIMITER //
CREATE PROCEDURE login
( 
    IN _correo 	VARCHAR(50),
    IN _pass 	VARCHAR(50)
)
BEGIN
	SELECT *
    FROM users AS u
    WHERE u.correo = _correo AND u.pass = _pass;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE spMostrarNotas
(
	IN id INT
)
BEGIN
	SELECT *
    FROM notes AS n
    WHERE n.id_usuario = id;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE spCrearNota
( 
    IN _id_usuario 		INT,
    IN _titulo			VARCHAR(100),
    IN _contenido		VARCHAR(500)
)
BEGIN
	DECLARE nombre_creador 	VARCHAR(100);
    
    SELECT u.nombre
    INTO nombre_creador
    FROM users AS u
    WHERE u.id = _id_usuario;
    
	INSERT INTO notes (id_usuario, nombre_creador, fecha, hora, titulo, contenido)  VALUES
	(_id_usuario, nombre_creador, CURDATE(), CURTIME(), _titulo, _contenido);
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE spActualizarNota
(
    IN _id 			INT,
    IN _titulo		VARCHAR(100),
    IN _contenido	VARCHAR(500)
)
BEGIN
	IF _titulo IS NOT NULL THEN
    	UPDATE notes
        SET titulo = _titulo
        WHERE id = _id;
    END IF;
    
	IF _contenido IS NOT NULL THEN
    	UPDATE notes 
        SET contenido = _contenido
        WHERE id = _id;
    END IF;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE spEliminarNota
( 
    IN _id INT
)
BEGIN
	DELETE FROM notes WHERE id = _id;
END//
DELIMITER ;