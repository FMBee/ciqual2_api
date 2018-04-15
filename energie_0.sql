
CREATE PROCEDURE `energie_0`()

BEGIN

BLOCK1: BEGIN

  declare _alim_code varchar(25);
  declare _const_code varchar(25);
  declare _teneur FLOAT default 0;
  declare _glucides FLOAT default 0;
  declare _lipides FLOAT default 0;
  declare _protides FLOAT default 0;
  declare _polyols FLOAT default 0;
  declare _fibres FLOAT default 0;
  declare _alcool FLOAT default 0;
  declare _acides FLOAT default 0;
  
  DECLARE f_liste1 INT DEFAULT 0;
  DECLARE f_liste2 INT DEFAULT 0;
  
  declare _liste1 cursor for 
    SELECT alim_code FROM alim_values_details 
    where trim(const_code)='327' and cast(teneur as int)=0 ORDER BY alim_code;
    
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET f_liste1 = 1;
  open _liste1;
  
  LOOP1: LOOP
    
        fetch _liste1 into _alim_code;
        
        IF f_liste1 = 1 THEN 
			
			close _liste1;
 			LEAVE LOOP1;
 		END IF; 
        
        DROP table if exists tmp_compo;
        
        CREATE table tmp_compo as 
            SELECT const_code, teneur from alim_values_details where alim_code = _alim_code;
            
        SELECT _glucides = convert(replace(teneur, ',', '.'), decimal(10, 2)) from tmp_compo where trim(const_code) = '31000';
        SELECT _lipides = convert(replace(teneur, ',', '.'), decimal(10, 2)) from tmp_compo where trim(const_code) = '40000';
        SELECT _protides = convert(replace(teneur, ',', '.'), decimal(10, 2)) from tmp_compo where trim(const_code) = '25000';
        SELECT _polyols = convert(replace(teneur, ',', '.'), decimal(10, 2)) from tmp_compo where trim(const_code) = '34000';
        SELECT _fibres = convert(replace(teneur, ',', '.'), decimal(10, 2)) from tmp_compo where trim(const_code) = '34100';
        SELECT _alcool = convert(replace(teneur, ',', '.'), decimal(10, 2)) from tmp_compo where trim(const_code) = '60000';
        SELECT _acides = convert(replace(teneur, ',', '.'), decimal(10, 2)) from tmp_compo where trim(const_code) = '65000';

update tmp_compo set teneur = convert(_glucides*_lipides*_protides, char) where trim(const_code) = '327';  
    
        leave LOOP1;

  END LOOP LOOP1;
  
END BLOCK1;  

END


//
call energie_0();


//
BEGIN
BLOCK1:BEGIN

    DECLARE variable1 INT;

    DECLARE  _cur_1 CURSOR FOR SELECT id FROM tbl_1;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET _cur1Done = 1;
    LOOP1: LOOP
    FETCH _cur_1 INTO variable1;
    IF _cur1Done THEN 
        CLOSE _cur_1;
        LEAVE LOOP1;
    END IF;

    BLOCK2:BEGIN

        DECLARE variable2 INT;

        DECLARE  _cur_2 CURSOR FOR SELECT id FROM tbl_2;

        DECLARE CONTINUE HANDLER FOR NOT FOUND SET _cur2Done = 1;

        OPEN _cur_2;
        LOOP2: LOOP

            FETCH _cur_2 INTO variable2;
            IF _cur2Done THEN
                CLOSE _cur_2;
                LEAVE LOOP2;
            END IF;
        END LOOP LOOP2;
    END BLOCK2;
END LOOP LOOP1;
END BLOCK1;
END $$