

 	-- insertion d'un groupe/catégorie
 	
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
			)


 	-- insertion d'un ingrédient
 	
 		INSERT INTO alim (
 			alim_code,
 			alim_grp_code,			
 			alim_ssgrp_code,			
 			alim_ssssgrp_code,		
 			alim_nom_fr,			
 			) VALUES 
 			(	
 			concat(' ', 'IM0001', ' '),
 			concat(' ', '99', ' '),                                  
			concat(' ', '9999', ' '),                                
			concat(' ', '999999', ' '),                              
 			concat(' ', 'Fond de tarte à le crème patissière 70g', ' ')
			)


 	-- insertion d'un nutriment
 	
 		INSERT INTO compo (
 			alim_code,				
 			const_code,				
 			teneur					
 			) VALUES 
 			(	
			concat(' ', 'IM0001', ' '),                                     
			concat(' ', '327', ' '),    
			concat(' ', '25,12', ' ')
			)
			


// codes nutriments
 			
10000 Cendres (g/100g) Ash (g/100g)
10004 Sel chlorure de sodium (g/100g) Salt (g/100g)
10110 Sodium (mg/100g) Sodium (mg/100g)
10120 Magnésium (mg/100g) Magnesium (mg/100g)
10150 Phosphore (mg/100g) Phosphorus (mg/100g)
10170 Chlorure (mg/100g) Chloride (mg/100g)
10190 Potassium (mg/100g) Potassium (mg/100g)
10200 Calcium (mg/100g) Calcium (mg/100g)
10251 Manganèse (mg/100g) Manganese (mg/100g)
10260 Fer (mg/100g) Iron (mg/100g)
10290 Cuivre (mg/100g) Copper (mg/100g)
10300 Zinc (mg/100g) Zinc (mg/100g)
10340 Sélénium (µg/100g) Selenium (µg/100g)
10530 Iode (µg/100g) Iodine (µg/100g)
25000 Protéines (g/100g) Protein (g/100g)
25003 Protéines brutes, N x 6.25 (g/100g) Protein, crude, N x 6.25 (g/100g)
31000 Glucides (g/100g) Carbohydrate (g/100g)
32000 Sucres (g/100g) Sugars (g/100g)
327 Energie, Règlement UE N° 1169/2011 (kJ/100g) Energy, Regulation EU No 1169/2011 (kJ/100g)
328 Energie, Règlement UE N° 1169/2011 (kcal/100g) Energy, Regulation EU No 1169/2011 (kcal/100g)
33110 Amidon (g/100g) Starch (g/100g)
332 Energie, N x facteur Jones, avec fibres (kJ/100g) Energy, N x Jones factor, with fibres (kJ/100g)
333 Energie, N x facteur Jones, avec fibres (kcal/100g) Energy, N x Jones factor, with fibres (kcal/100g)
34000 Polyols totaux (g/100g) Polyols (g/100g)
34100 Fibres alimentaires (g/100g) Fibres (g/100g)
400 Eau (g/100g) Water (g/100g)
40000 Lipides (g/100g) Fat (g/100g)
40302 AG saturés (g/100g) FA saturated (g/100g)
40303 AG monoinsaturés (g/100g) FA mono (g/100g)
40304 AG polyinsaturés (g/100g) FA poly (g/100g)
40400 AG 4:0, butyrique (g/100g) FA 4:0 (g/100g)
40600 AG 6:0, caproïque (g/100g) FA 6:0 (g/100g)
40800 AG 8:0, caprylique (g/100g) FA 8:0 (g/100g)
41000 AG 10:0, caprique (g/100g) FA 10:0 (g/100g)
41200 AG 12:0, laurique (g/100g) FA 12:0 (g/100g)
41400 AG 14:0, myristique (g/100g) FA 14:0 (g/100g)
41600 AG 16:0, palmitique (g/100g) FA 16:0 (g/100g)
41800 AG 18:0, stéarique (g/100g) FA 18:0 (g/100g)
41819 AG 18:1 9c (n-9), oléique (g/100g) FA 18:1 n-9 cis (g/100g)
41826 AG 18:2 9c,12c (n-6), linoléique (g/100g) FA 18:2 9c,12c (n-6) (g/100g)
41833 AG 18:3 c9,c12,c15 (n-3), alpha-linolénique (g/100g) FA 18:3 c9,c12,c15 (n-3) (g/100g)
42046 AG 20:4 5c,8c,11c,14c (n-6), arachidonique (g/100g) FA 20:4 5c,8c,11c,14c (n-6) (g/100g)
42053 AG 20:5 5c,8c,11c,14c,17c (n-3) EPA (g/100g) FA 20:5 5c,8c,11c,14c,17c (n-3) EPA (g/100g)
42263 AG 22:6 4c,7c,10c,13c,16c,19c (n-3) DHA (g/100g) FA 22:6 4c,7c,10c,13c,16c,19c (n-3) DHA (g/100g)
51200 Rétinol (µg/100g) Retinol (µg/100g)
51330 Beta-Carotène (µg/100g) Beta-carotene (µg/100g)
52100 Vitamine D (µg/100g) Vitamin D (µg/100g)
53100 Vitamine E (mg/100g) Vitamin E (mg/100g)
54101 Vitamine K1 (µg/100g) Vitamin K1 (µg/100g)
54104 Vitamine K2 (µg/100g) Vitamin K2 (µg/100g)
55100 Vitamine C (mg/100g) Vitamin C (mg/100g)
56100 Vitamine B1 ou Thiamine (mg/100g) Vitamin B1 or Thiamin (mg/100g)
56200 Vitamine B2 ou Riboflavine (mg/100g) Vitamin B2 or Riboflavin (mg/100g)
56310 Vitamine B3 ou PP ou Niacine (mg/100g) Vitamin B3 or Niacin (mg/100g)
56400 Vitamine B5 ou Acide pantothénique (mg/100g) Vitamin B5 or Pantothenic acid (mg/100g)
56500 Vitamine B6 (mg/100g) Vitamin B6 (mg/100g)
56600 Vitamine B12 (µg/100g) Vitamin B12 (µg/100g)
56700 Vitamine B9 ou Folates totaux (µg/100g) Vitamin B9 or Folate (µg/100g)
60000 Alcool (g/100g) Alcohol (g/100g)
65000 Acides organiques (g/100g) Organic acids (g/100g)
75100 Cholestérol (mg/100g) Cholesterol (mg/100g)