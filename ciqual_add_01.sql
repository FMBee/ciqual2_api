

 		INSERT INTO alim_grp (
 			alim_grp_code,			
 			alim_ssgrp_code,			
 			alim_ssssgrp_code,		
 			alim_grp_nom_fr,		
 			alim_ssgrp_nom_fr,		
 			alim_ssssgrp_nom_fr	
 			) VALUES 
 			(	
 			concat(' ', '99', ' '),                                  
			concat(' ', '9999', ' '),                                
			concat(' ', '999999', ' '),                              
			concat(' ', 'Pâtisserie BASE CATEGORIE BOULPAT', ' '),   
			concat(' ', 'Pâtisserie BASE CATEGORIE BOULPAT', ' '),   
			concat(' ', 'Pâtisserie BASE CATEGORIE BOULPAT ', ' ')  
			);

 		INSERT INTO alim (
 			alim_code,
 			alim_grp_code,			
 			alim_ssgrp_code,			
 			alim_ssssgrp_code,		
 			alim_nom_fr			
 			) VALUES 
 			(	
 			concat(' ', 'IM001', ' '),
 			concat(' ', '99', ' '),                                  
			concat(' ', '9999', ' '),                                
			concat(' ', '999999', ' '),                              
 			concat(' ', 'Fond de tarte à la crème patissière 70g', ' ')
			),
 			(	
 			concat(' ', 'IM002', ' '),
 			concat(' ', '99', ' '),                                  
			concat(' ', '9999', ' '),                                
			concat(' ', '999999', ' '),                              
 			concat(' ', 'Fond de tarte à la crème patissière 442g', ' ')
			);


 		INSERT INTO compo (
 			alim_code,				
 			const_code,				
 			teneur					
 			) VALUES 
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '327', ' '),    
			concat(' ', '1514', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '328', ' '),    
			concat(' ', '361', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '332', ' '),    
			concat(' ', '1514', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '333', ' '),    
			concat(' ', '361', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '25000', ' '),    
			concat(' ', '4,9', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '25003', ' '),    
			concat(' ', '4,9', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '31000', ' '),    
			concat(' ', '50,4', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '40000', ' '),    
			concat(' ', '15,2', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '32000', ' '),    
			concat(' ', '25,7', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '34100', ' '),    
			concat(' ', '1,3', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '40302', ' '),    
			concat(' ', '8,1', ' ')
			),
 			(	
			concat(' ', 'IM001', ' '),                                     
			concat(' ', '10004', ' '),    
			concat(' ', '0,4', ' ')
			),

 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '327', ' '),    
			concat(' ', '1335', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '328', ' '),    
			concat(' ', '318', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '332', ' '),    
			concat(' ', '1335', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '333', ' '),    
			concat(' ', '318', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '25000', ' '),    
			concat(' ', '4,8', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '25003', ' '),    
			concat(' ', '4,8', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '31000', ' '),    
			concat(' ', '48', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '40000', ' '),    
			concat(' ', '11,5', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '32000', ' '),    
			concat(' ', '25,2', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '34100', ' '),    
			concat(' ', '1,2', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '40302', ' '),    
			concat(' ', '6', ' ')
			),
 			(	
			concat(' ', 'IM002', ' '),                                     
			concat(' ', '10004', ' '),    
			concat(' ', '0,3', ' ')
			);		
			
			
