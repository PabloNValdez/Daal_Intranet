// Los SKU asociados a las botellas
    /*$allowed_skus_bottle = ['040560004-500-ef-celta', '040560004-500-ef-granada', '040560004-500-ef-espanyol', '040560004-500-ef-villarreal', '040560004-500-ef-girona', 
                            '040560004-500-ef-cadiz', '4055-botnom-350verde', '4055-botnom-750verde', '4055-bl-750-nommedio', '040560004-500-pl-fut3-', '4055-botdis-500foto',
                            '4055-botdis-350foto', '4055-botdis-750foto', '4055-botnominicial-500Plumas', '040560004-500-ef-rsociedad', '040560004-500-ef-athletic', '040560004-500-ef-valencia',
                            '040560004-500-ef-valencia', '040560004-500-ef-atmadrid', '040560004-500-ef', '040560004-500-ef-betis', '040560004-500-ef-barca', '040560004-500-ef-sevilla',
                            '040560004-500-ef-madrid' , '040560004-500-plat-fut4-', '040560004-500-bl-tenis1-', '040560004-500-verde-fut4', '040560004-500-plat-futbol1', '040560004-500-bl-fut2',
                            '040560004-500-bl-basq2', '040560004-500-ver-basq1', '040560004-500-bl-padel1', '040560004-500-pl-padel2', '040560004-500-am-fut4', '040560004-500-bl',
                            '040560004-500-am-padel2', '040560004-500-pl-tenis1', '040560004-500-ver-tenis1', '040560004-500-am-basq1', '040560004-500-am-fut1', '040560004-500-am-padel1', 
                            '040560004-500-pl-basq1', '040560004-500-ver-fut1', '040560004-500-ver-fut2', '040560004-500-bl-tenis2', '040560004-500-ver-fut3', '040560004-500-am-tenis1', 
                            '040560004-500-am-fut3', '040560004-500-bl-padel2', '040560004-500-pl-basq2', '040560004-500-bl-fut3', '040560004-500-ver-padel2', '040560004-500-bl-fut1', 
                            '040560004-500-am-basq2', '040560004-500-ver-basq2', '040560004-500-ver-padel1', '040560004-500-am-fut2', '040560004-500-bl-basq1', '040560004-500-pl-tenis2', 
                            '040560004-500-bl-fut4', '040560004-500-am-tenis2', '040560004-500-pl-fut2', '040560004-500-ver-tenis2', '040560004-500-pl-padel1', '4055-bi-350nommedio', 
                            '4055-bi-750nomdebajo', '4055-bi-350nomdebajo', '4055-bi-500nommedio', '4055-bi-500nomdebajo', '4055-botcumple-500Mentalida', '4055-botcumple-750Cantinú', 
                            '4055-botcumple-350Maravill', '4055-botcumple-350Losabe', '4055-botcumple-500Losabe', '4055-botcumple-750Maravill', '4055-botcumple-500Carr', '040560009-NomInic-EmojisRosa', 
                            '040560009-NomInic-DinoRosa', '040560009-NomInic-UnicorRosa', '040560009-NomInic-DinoAzul', '040560009-NomInic', '040560009-NomInic-AnimRosa', '040560009-NomInic-GeomeAzul', 
                            '040560009-NomInic-EmojisAzul', '040560009-NomInic-UnicorAzul', '040560009-NomInic-GeomeRosa', '040560009-NomInic-AnimAzul', '040560009-Nom', '040560009-Nom-SolLunaRosa', 
                            '040560009-Nom-IndioRosa', '040560009-Nom-ZebraRosa', '040560009-Nom-ZebraAzul', '040560009-Nom-ConejitoAzul', '040560009-Nom-IndioAzul', '040560009-Nom-ArcoirisAzul', 
                            '040560009-Nom-SolLunaAzul', '040560009-Nom-ConejitoRosa', '040560009-Nom-ArcoirisRosa', '040560009-Nom-ZorroAzul', '040560009-Nom-ZorroRosa', '4055-botcumple-350Granaño', 
                            '4055-botcumple-750Losabes', '4055-botcumple-500Montón', '4055-botcumple-750Carro', '4055-botcumple-500Cantinúa', '4055-botcumple-500Maravilla', '4055-botcumple-350Cantinúa', 
                            '4055-botcumple-750Montón', '4055-botcumple-500Granaño', '4055-botcumple-750Mentalidad', '4055-botcumple-350Mentalidad', '4055-botcumple-350Carro', '4055-botcumple', 
                            '4055-botcumple-750Granaño', '4055-botcumple-350Cumple', '4055-botcumple-350Masuno', '4055-botcumple-350Montón', '4055-botcumple-750Cumplea', '4055-botcumple-500Masuno', 
                            '4055-botcumple-750Masuno', '4055-botcumple-500Cumplea', '4055-botnominicial-350Cactus', '4055-botnominicial-500Laurel', '4055-botnominicial-500Floral', '4055-botnominicial-750Laurel', 
                            '4055-botnominicial-500Script', '4055-botnominicial-350Script', '4055-botnominicial-350Plumas', '4055-botnominicial-750Script', '4055-botnominicial-750Cactus', '4055-botnominicial-750Plumas', 
                            'botnominicial-500-Cactus', '4055-botnominicial-350Laurel', '4055-botnominicial-750Floral', '4055-botnominicial-350Floral', '4055-botnominicial', '4055-botnomfrases-350Siempre', 
                            '4055-botnomfrases-500-Siempre', '4055-botnomfrases-750Lugarfavorito', '4055-botnomfrases-750Atulado', '4055-botnomfrases-750Favorita', '4055-botnomfrases-350Atulado', '4055-botnomfrases-500Atulado', 
                            '4055-botnomfrases-350Vida', '4055-botnomfrases-350Favorita', '4055-botnomfrases-500Mejor', 'botnomfrases-350Mejor', 'botnomfrases-750Especial', 'botnomfrases-500Especial', 
                            'botnomfrases-500Lugarfavorito', '4055-botnomfrases-350Especial', '4055-botnomfrases-500-Vida', '4055-botnomfrases-350Lugarfavorito', '4055-botnomfrases-750Vida', '4055-botnomfrases-500Favorita', 
                            '4055-botnomfrases-750Siempre', '4055-botnomfrases-750Mejor', '4055-botnomfrases', '4055-botnombre-500plateado-purpurina', '4055-botnombre-500cobre-purpurina', '4055-botnombre-500rosa-purpurina', 
                            '040560009-azul', '040560009-rosa', '040560009', '4055-botpadre750-mogollon', '4055-botpadre500-felicidades', '4055-botpadre350-mejorabuelo', '4055-botpadre750-gracias', '4055-botpadre750-papi',
                            '4055-botpadre350-mogollon', '4055-botpadre350-escudo', '4055-botpadre500-todoymas', '4055-botpadre750-100', '4055-botpadre750-escrito', '4055-botpadre500-mogollon', 
                            '4055-botpadre750-felicidades', '4055-botpadre500-100', '4055-botpadre500-encasa', '4055-botpadre350-chupetepapa', '4055-botpadre500-mejorabuelo', '4055-botpadre500-escudo', 
                            '4055-botpadre350-encasa', '4055-botpadre350-gracias', '4055-botpadre750-todoymas', '4055-botpadre350-casapapa', '4055-botpadre350-mejorapapa', '4055-botpadre750-encasa', 
                            '4055-botpadre500-escrito', '4055-botpadre350-rayas', '4055-botpadre', '4055-botpadre500-mejorpapa', '4055-botpadre500-chupetepapa', '4055-botpadre350-papi', '4055-botpadre750-mejorabuelo',
                            '4055-botpadre750-chupetepapa', '4055-botpadre500-rayas', '4055-botpadre350-escrito', '4055-botpadre750-rayas', '4055-botpadre350-todoymas', '4055-botpadre750-escudo', 
                            '4055-botpadre500-casapapa', '4055-botpadre750-casapapa', '4055-botpadre500-gracias', '4055-botpadre350-felicidades', '4055-botpadre750-mejorpapa', '4055-botpadre500-papi', 
                            '4055-botpadre350-100', '4055-botdis-750dust', '4055-botdis-500geometric', '4055-botbdis-350geometric', '4055-botdis-750stripes', '4055-botdis-750love', '4055-botdis-750arrows',
                            '4055-botdis-500dust', '4055-botdis-750geometric', '4055-botdis-500love', '4055-botdis-500stripes', '4055-botdis-350stripes', '4055-botdis-350love', '4055-botdis', '4055-botbl-350plateado',
                            '4055-botnombre', '4055-botnombre-500blanco', '4055-botbl-500plateado', '4055-botnombre-500lila', '4055-botbl-500verde', '4055-botnombre-350amarillo', '4055-botnombre-750blanco',
                            '4055-botnombre-350blanco', '4055-botnombre-500amarillo', '4055-botbl-750plateado', '4055-botnombre-750lila', '4055-botnombre-750amarillo', '4055-botnombre-350lila', 
                            '4055-botella500verde', '4055-botella500blanca', '4055-botella750blanca', '4055-botella500lila', '4055-botella500amarillo', '4055-botella500plateado', '4055-botella750plateado',
                            '4055-botella350verde', '4055-botella350lila', '4055-botella350amarillo', '4055-botella750verde', '4055-botella750lila', '4055-botella750amarillo', '4055-botella350plateado',
                            '4055-botella350blanca', '4055-botella', '1303-botellaaluminio', '1303-botellaaluminio-blanca', '1303-botellaaluminio-plata'];*/



                            //Los SKU asociados a las Botellas Deportes
    $allowed_skus_botella_deportes = ['040560004-500-pl-fut3-', '040560004-500-plat-fut4-', '040560004-500-bl-tenis1-', '040560004-500-verde-fut4', '040560004-500-plat-futbol1', 
                                 '040560004-500-bl-fut2', '040560004-500-bl-basq2', '040560004-500-ver-basq1', '040560004-500-bl-padel1', '040560004-500-pl-padel2', '040560004-500-am-fut4', 
                                 '040560004-500-bl', '040560004-500-am-padel2', '040560004-500-pl-tenis1', '040560004-500-ver-tenis1', '040560004-500-am-basq1', '040560004-500-am-fut1', 
                                 '040560004-500-am-padel1', '040560004-500-pl-basq1', '040560004-500-ver-fut1', '040560004-500-ver-fut2', '040560004-500-bl-tenis2', '040560004-500-ver-fut3', 
                                 '040560004-500-am-tenis1', '040560004-500-am-fut3', '040560004-500-bl-padel2', '040560004-500-pl-basq2', '040560004-500-bl-fut3', '040560004-500-ver-padel2', 
                                 '040560004-500-bl-fut1', '040560004-500-am-basq2', '040560004-500-ver-basq2', '040560004-500-ver-padel1', '040560004-500-am-fut2', '040560004-500-bl-basq1', 
                                 '040560004-500-pl-tenis2', '040560004-500-bl-fut4', '040560004-500-am-tenis2', '040560004-500-pl-fut2', '040560004-500-ver-tenis2', '040560004-500-pl-padel1'];
    //Los SKU asociados a las Botellas Equipos
    $allowed_skus_botella_equipos = ['040560004-500-ef-rsociedad', '040560004-500-ef-athletic', '040560004-500-ef-valencia', '040560004-500-ef-valencia', '040560004-500-ef-betis', 
                                     '040560004-500-ef-barca', '040560004-500-ef-sevilla', '040560004-500-ef-madrid', '040560004-500-ef-atmadrid'];


                                     040560004-500-ef-celta

                                     '040560004-500-ef-celta'








                                     040560004-500-ef'


'4055-botcumple-500Mentalida'
'4055-botcumple-750Cantinú'
'4055-botcumple-350Maravill'
'4055-botcumple-350Losabe'
'4055-botcumple-500Losabe'
'4055-botcumple-750Maravill'
'4055-botcumple-500Carr'
'4055-botcumple-350Granaño'
'4055-botcumple-750Losabes'
'4055-botcumple-500Montón'
'4055-botcumple-750Carro'
'4055-botcumple-500Cantinúa'
'4055-botcumple-500Maravilla'
'4055-botcumple-350Cantinúa'
'4055-botcumple-750Montón'
'4055-botcumple-500Granaño'
'4055-botcumple-750Mentalidad'
'4055-botcumple-350Mentalidad'
'4055-botcumple-350Carro'
'4055-botcumple'
'4055-botcumple-750Granaño'
'4055-botcumple-350Cumple'
'4055-botcumple-350Masuno'
'4055-botcumple-350Montón'
'4055-botcumple-750Cumplea'
'4055-botcumple-500Masuno'
'4055-botcumple-750Masuno'
'4055-botcumple-500Cumplea'
'4055-botcumple-500Laurel'
'4055-botcumple-750Laurel'
'4055-botcumple-350Laurel'
'4055-botcumple-500Plumas'
'4055-botcumple-750Plumas'
'4055-botcumple-350Plumas'
'4055-botcumple-500Floral'
'4055-botcumple-750Floral'
'4055-botcumple-350Floral'
'4055-botcumple-750Script'
'4055-botcumple-500Script'
'4055-botcumple-350Script'
'4055-botcumple-750Cactus'
'4055-botcumple-500Cactus'
'4055-botcumple-350Cactus'

//Estas son tazas y cojines en combo. Hay que ver qué hacer.
'1739-madre-mejormama'
'1739-madre-felicidades'
'1739-madre-mandona'
'1739-madre-casamama'
'1739-madre-escrito'
'1739-madre-mejorabuela'
'1739-mama-flores'
'1739-madre-chupete'
'1739-madre-encasa'
'1739-madre-100%'
'936-1739-abuelo-mejorabuelos'
'936-1739-abuelo'
'936-1739-abuela-scrapbook'
'936-1739-abuela-aro'
'936-1739-abuelo-marco'
'936-1739-abuelo-scrapbook'
'936-1739-abuelo-aro'
'936-1739-abuela-escudo'
'936-1739-abuelos-escudo'
'936-1739-abuelo-mejorabuelo'
'936-1739-abuelo-mejorabuela'
'936-1739-abuelo-escudo'
'936-1739-padre'
'936-1739-padre-todomas'
'936-1739-padre-chupetepapa'
'936-1739-padre-escrito'
'936-1739-padre-100%'
'936-1739-padre-escudo'
'936-1739-padre-mejorpapa', 
'936-1739-padre-gracias', 
'936-1739-padre-rayas', 
'936-1739-padre-felicidades', 
'936-1739-padre-mejorabuelo', 
'936-1739-padre-encasa', 
'936-1739-padre-mogollon'
'936-1739-mama-mejor'
'936-1739-diseño-coñazo'
'936-1739-mama-caña'
'936-1739-mama-increible'
'936-1739-siempre-juntas'
'936-1739-foto-coñazo'






































































































