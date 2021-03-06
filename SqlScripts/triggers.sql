DELIMITER $$
-- TRIGGER 1
-- Genera una notificación si se envía una solicitud a un usuario.
CREATE TRIGGER `notificacion_request` AFTER INSERT ON `requests`
 FOR EACH ROW BEGIN 

SET @id_user_2 	= (SELECT NEW.user_id);
SET @cont_notif = (SELECT NEW.nombre_solicitud);

INSERT INTO notifications(URL, CONTENIDO, FECHA)
			SELECT '', @cont_notif, NOW();

SET @id_notificacion_2 = (SELECT ID
						  FROM notifications
						  ORDER BY ID DESC
						  LIMIT 1);

INSERT INTO notifications_users(ID_USER, ID_NOTIFICATION)
			SELECT @id_user_2, @id_notificacion_2;

END
$$


-- TRIGGER 2
-- Genera una notificación si se elimina un administrador o un encargado de emergencia
CREATE TRIGGER `notificacion_delete_user` BEFORE DELETE ON `users`
 FOR EACH ROW BEGIN

IF OLD.ADMIN=1 THEN
	SET @bool = (SELECT COUNT(*)
				 FROM emergencies
				 WHERE emergencies.user_id = OLD.id);
		IF @bool>0 THEN
			INSERT INTO notifications(URL, CONTENIDO, FECHA) 
			SELECT '', 'Se necesita un administrador', NOW();

			SET @id_notificacion_2 = (SELECT id 
                                      FROM notifications
                                      ORDER BY id DESC 
                                      LIMIT 1); 
			INSERT INTO notifications_users(user_id, notification_id) 
			SELECT ID, @id_notificacion_2 FROM users WHERE 			users.admin = 1;
	END IF;
    SET @bool = (SELECT COUNT(*)
				 FROM missions
				 WHERE missions.user_id = OLD.id);
	IF @bool>0 THEN
			INSERT INTO notifications(URL, CONTENIDO, FECHA) 
		SELECT '', 'Se necesita un encargado de emergencia', NOW();

		SET @id_notificacion_2 = (SELECT ID 
								  FROM notifications
								  ORDER BY id DESC 
								  LIMIT 1);
		SET @encargados = (SELECT users.ID
                           FROM users JOIN missions
                           ON users.ID = missions.USER_ID);
		INSERT INTO notifications_users(user_id, notification_id) 			SELECT @encargados, @id_notificacion_2;
	END IF;
ELSE
	SET @bool = (SELECT COUNT(*)
				 FROM missions
				 WHERE missions.user_id = OLD.id);
	IF @bool>0 THEN
			INSERT INTO notifications(URL, CONTENIDO, FECHA) 
		SELECT '', 'Se necesita un encargado de emergencia', NOW();

		SET @id_notificacion_2 = (SELECT ID 
								  FROM notifications
								  ORDER BY id DESC 
								  LIMIT 1);
		SET @encargados = (SELECT users.ID
                           FROM users JOIN missions
                           ON users.ID = missions.USER_ID);
		INSERT INTO notifications_users(user_id, notification_id) 			SELECT @encargados, @id_notificacion_2;
	END IF;
END IF;

END
$$
