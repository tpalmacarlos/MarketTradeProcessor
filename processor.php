<?php

/**
 * Processing is done using a mySQL trigger
 */

/*
delimiter //
#DROP TRIGGER ins_tx;
CREATE TRIGGER ins_tx AFTER INSERT ON tx
	FOR EACH ROW BEGIN
		DECLARE updatecount INT;

		SET updatecount = ( SELECT COUNT(id) FROM stats WHERE currencyFrom = NEW.currencyFrom AND currencyTo = NEW.currencyFrom );
		IF updatecount IS NULL THEN
			INSERT INTO stats ( currencyFrom, currencyTo, count, sum ) VALUES ( NEW.currencyFrom, NEW.currencyTo, 1, NEW.amountSell );
		ELSE
			UPDATE stats SET count = count+1, sum = sum + NEW.amountSell WHERE currencyFrom = NEW.currencyFrom AND currencyTo = NEW.currencyTo;
			#UPDATE stats SET count = count+1, sum = sum + NEW.amountSell WHERE currencyFrom = NEW.currencyFrom AND currencyTo = NEW.currencyFrom;
		END IF;
	END
*/
?>