<?php 
    require 'includes/funciones.php';
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    //use ZipArchive;

    //Los SKU asociados a las placas Spotify BASE
    $allowed_skus_spotify_base = ['XG-XTS3-4OW8', 'RY-SFSN-TEZ8', 'IG-3M8S-0B0S'];
    //Los SKU asociados a las placas Spotify Luz
    $allowed_skus_spotify_luz = ['Placa_Luz'];
    //Los SKU asociados a las placas Spotify 1LLAV
    $allowed_skus_spotify_1llavero = ['PLACA-1LLAV'];
    //Los SKU asociados a las placas Spotify 2LLAV
    $allowed_skus_spotify_2llaveros = ['PLACA-2LLAV'];

    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    /* '4055-botcumple-500Mentalida''4055-botcumple-750Cantinú''4055-botcumple-350Maravill''4055-botcumple-350Losabe''4055-botcumple-500Losabe''4055-botcumple-750Maravill'
    '4055-botcumple-500Carr''4055-botcumple-350Granaño''4055-botcumple-750Losabes''4055-botcumple-500Montón''4055-botcumple-750Carro''4055-botcumple-500Cantinúa'
    '4055-botcumple-500Maravilla''4055-botcumple-350Cantinúa''4055-botcumple-750Montón''4055-botcumple-500Granaño''4055-botcumple-750Mentalidad''4055-botcumple-350Mentalidad'
    '4055-botcumple-350Carro''4055-botcumple''4055-botcumple-750Granaño''4055-botcumple-350Cumple''4055-botcumple-350Masuno''4055-botcumple-350Montón''4055-botcumple-750Cumplea'
    '4055-botcumple-500Masuno''4055-botcumple-750Masuno''4055-botcumple-500Cumplea''4055-botcumple-500Laurel''4055-botcumple-750Laurel''4055-botcumple-350Laurel'
    '4055-botcumple-500Plumas''4055-botcumple-750Plumas''4055-botcumple-350Plumas''4055-botcumple-500Floral''4055-botcumple-750Floral''4055-botcumple-350Floral''4055-botcumple-750Script'
    '4055-botcumple-500Script''4055-botcumple-350Script''4055-botcumple-750Cactus''4055-botcumple-500Cactus''4055-botcumple-350Cactus'  */

    //Los SKU asociados a las Botellas 350_Blanco
    $allowed_skus_350_Blanco = ['4055-botella350blanca','4055-botdis-350foto','4055-bi-350nommedio','4055-bi-350nomdebajo','4055-botnomfrases-350Atulado',
                                '4055-botnomfrases-350Vida','4055-botnomfrases-350Favorita','botnomfrases-350Mejor','botnominicial-350-Laurel','botnominicial-350-Plumas',
                                'botnominicial-350-Floral','4055-botnombre-350blanco','4055-botnomfrases-350Especial','4055-botnomfrases-350Lugarfavorito'];
    //Los SKU asociados a las Botellas 350_Blanco_Diseno
    $allowed_skus_350_Blanco_Diseno = ['4055-botnominicial-350Cactus','4055-botnominicial-350Script','4055-botnominicial-350Plumas','4055-botnomfrases-350Siempre',
                                       '4055-botnominicial-350Laurel','4055-botnominicial-350Floral','4055-botdis-350geometric','4055-botdis-350stripes','4055-botdis-350love'];              
    //Los SKU asociados a las Botellas 500_Blanco
    $allowed_skus_500_Blanco = ['4055-botella500blanca', '4055-botdis-500foto','4055-botnominicial-500Plumas','4055-botnominicial-500Laurel','4055-botnominicial-500Floral',
                                '4055-botnominicial-500Script','040560009-NomInic','040560009-Nom','040560004-500-bl','4055-bi-500nommedio','4055-bi-500nomdebajo',
                                '4055-botnomfrases-500-Siempre','4055-botnomfrases-500Atulado','4055-botnomfrases-500Mejor','botnomfrases-500Especial','botnomfrases-500Lugarfavorito',
                                'botnomfrases-500Lomás','4055-botnombre-500blanco','4055-botnombre','4055-botnomfrases-500Favorita','4055-botnomfrases-500-Vida'];
    //Los SKU asociados a las Botellas 500_Blanco_Diseno
    $allowed_skus_500_Blanco_Diseno = ['4055-botdis-500geometric', '4055-botdis-500dust', '4055-botdis-500love','4055-botdis-500stripes', '040560004-500-ef-barca', '040560004-500-ef-athletic',
                                       '040560004-500-ef-espanyol', '040560004-500-ef-celta', '040560004-500-ef-atmadrid', '040560004-500-bl-fut1','040560004-500-ef-granada',
                                       '040560004-500-ef-villarreal','040560004-500-ef-girona','040560004-500-ef-cadiz', '040560004-500-ef-rsociedad', '040560004-500-ef-valencia',
                                       '040560004-500-ef-betis','040560004-500-ef-sevilla','040560004-500-ef-madrid','040560004-500-bl-tenis1-','040560004-500-bl-fut2',
                                       '040560004-500-bl-basq2','040560004-500-bl-padel1','040560004-500-bl-padel2','040560004-500-bl-fut4'];                                
    //Los SKU asociados a las Botellas 750_Blanco
    $allowed_skus_750_Blanco = ['4055-botella750blanca', '4055-bl-750-nommedio','4055-botdis-750foto','4055-bi-750nomdebajo','4055-botnombre-750blanco',
                                '4055-botnomfrases-750Mejor','4055-botnomfrases-750Siempre','4055-botnomfrases-750Vida','botnomfrases-750Especial','4055-botnomfrases-750Lugarfavorito',
                                '4055-botnomfrases-750Atulado','4055-botnomfrases-750Favorita'];
    //Los SKU asociados a las Botellas 750_Blanco_Diseno
    $allowed_skus_750_Blanco_Diseno = ['4055-botdis-750geometric','4055-botdis-750dust','4055-botdis-750stripes','4055-botdis-750love','4055-botdis-750arrows','4055-botnominicial-750-Cactus','4055-botnominicial-750Laurel',
                                '4055-botnominicial-750Script','4055-botnominicial-750Cactus','4055-botnominicial-750Plumas','4055-botnominicial-750Floral'];
    


    //Los SKU asociados a las Botellas 350_Plata
    $allowed_skus_350_Plata = ['4055-botella350plateado', '4055-botbl-350plateado'];                   
    //Los SKU asociados a las Botellas 500_Plateado
    $allowed_skus_500_Plata = ['4055-botella500plateado', '4055-botbl-500plateado','4055-botnombre-500plateado'];
    //Los SKU asociados a las Botellas 500_Plata_Diseno
    $allowed_skus_500_Plata_Diseno = ['040560004-500-pl-fut3-','040560004-500-pl-fut2','040560004-500-pl-tenis1','040560004-500-pl-padel2','040560004-500-pl-basq1',
                                      '040560004-500-pl-basq2','040560004-500-pl-tenis2','040560004-500-pl-padel1','040560004-500-plat-fut4-','040560004-500-plat-futbol1',
                                      '040560004-500-plat-basq1','040560004-500-plat-basq2'];
    //Los SKU asociados a las Botellas 750_Plata
    $allowed_skus_750_Plata = ['4055-botella750plateado','4055-botnombre-750plateado'];



    //Los SKU asociados a las Botellas 350_Verde
    $allowed_skus_350_Verde = ['4055-botella350verde', '4055-botnom-350verde','4055-botnombre-350verde'];
    //Los SKU asociados a las Botellas 500_Verde
    $allowed_skus_500_Verde = ['4055-botella500verde', '4055-botbl-500verde','4055-botnombre-500verde'] ;
    //Los SKU asociados a las Botellas 500_Verde_Diseno
    $allowed_skus_500_Verde_Diseno = ['040560004-500-verde-fut4','040560004-500-ver-basq1','040560004-500-ver-fut1','040560004-500-ver-fut2','040560004-500-ver-fut3',
                                      '040560004-500-ver-basq2','040560004-500-ver-padel2','040560004-500-ver-padel1','040560004-500-ver-tenis1','040560004-500-ver-tenis2'];
    //Los SKU asociados a las Botellas 750_Verde
    $allowed_skus_750_Verde = ['4055-botella750verde','4055-botnom-750verde','4055-botnombre-750verde'];


    //Los SKU asociados a las Botellas 350_Lila
    $allowed_skus_350_Lila = ['4055-botella350lila','4055-botnombre-350lila'];
    //Los SKU asociados a las Botellas 500_Lila
    $allowed_skus_500_Lila = ['4055-botella500lila', '4055-botnombre-500lila','4055-botnombre-500lila'];
    //Los SKU asociados a las Botellas 750_Lila
    $allowed_skus_750_Lila = ['4055-botella750lila','4055-botnombre-750lila'];

    

    //Los SKU asociados a las Botellas 350_Amarillo
    $allowed_skus_350_Amarillo = ['4055-botella350amarillo','4055-botnombre-350amarillo'];
    //Los SKU asociados a las Botellas 500_Amarillo
    $allowed_skus_500_Amarillo = ['4055-botella500amarillo','4055-botnombre-500amarillo'];
    //Los SKU asociados a las Botellas 500_Amarillo_Diseno
    $allowed_skus_500_Amarillo_Diseno = ['040560004-500-am-fut4','040560004-500-am-padel2','040560004-500-am-basq1','040560004-500-am-fut1','040560004-500-am-padel1','040560004-500-am-tenis1',
                                         '040560004-500-am-fut3','040560004-500-am-basq2','040560004-500-am-fut2','040560004-500-am-tenis2'];
    //Los SKU asociados a las Botellas 750_Amarillo
    $allowed_skus_750_Amarillo = ['4055-botella750amarillo','4055-botnombre-750amarillo'];


    //Los SKU asociados a las Botellas 500_Rosa_Purpurina
    $allowed_skus_500_Rosa_Purpurina = ['4055-botnombre-500rosa-purpurina'];

    //Los SKU asociados a las Botellas 500_Cobre_Purpurina
    $allowed_skus_500_Cobre_Purpurina = ['4055-botnombre-500cobre-purpurina'];

    //Los SKU asociados a las Botella_infantil_Rosa
    $allowed_skus_infantil_Rosa = ['040560009-NomInic-EmojisRosa','040560009-NomInic-DinoRosa','040560009-NomInic-UnicorRosa','040560009-NomInic-AnimRosa','040560009-NomInic-GeomeRosa',
                                   '040560009-Nom-SolLunaRosa','040560009-Nom-IndioRosa','040560009-Nom-ZebraRosa','040560009-Nom-ConejitoRosa','040560009-Nom-ArcoirisRosa','040560009-Nom-ZorroRosa'];

    //Los SKU asociados a las Botella_infantil_Azul
    $allowed_skus_infantil_Azul = ['040560009-NomInic-DinoAzul','040560009-NomInic-EmojisAzul','040560009-NomInic-UnicorAzul','040560009-NomInic-GeomeAzul','040560009-NomInic-AnimAzul',
                                   '040560009-Nom-SolLunaAzul','040560009-Nom-IndioAzul','040560009-Nom-ZebraAzul','040560009-Nom-ConejitoAzul','040560009-Nom-ArcoirisAzul','040560009-Nom-ZorroAzul'];

    //Los SKU asociados a las Botellas 500_Plata_Purpurina
    $allowed_skus_500_Plata_Purpurina = ['4055-botnombre-500plateado-purpurina'];

    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    //Los SKU asociados a los Felpudo_33x60
    $allowed_skus_Felpudo_33x60 = ['Felp_Pedro33x60','fel-pareja-2masc-33x60','fel-fliaparej-33x60','fel-flia3-2masc-33x60','flpd-nombre-bienv-33x60','flpd-nombre-inic-33x60',
                                   'fel-flia3-33x60-','fel-flia6-33x60','fel-pareja-3mascota-33x60','fel-flia5-33x60','fel-flia4-mascota-33x60','fel-flia5-mascota-33x60',
                                   'fel-soltero-mascota-33x60','fel-soltero-hijo-33x60','fel-pareja-mascota-33x60','fel-flia4-2mascota-33x60','fel-flia4-33x60', 'flpd-fliapareja-33x60',
                                   'fel-flia3-mascota-33x60','flpd-fliapareja-perrogat-33x60','flpd-flia5-33x60','flpd-flia3-33x60','flpd-flia3-perrogato-33x60','flpd-flia4-33x60',
                                   'flpd-flia4-perrogato-33x60','flpd-nombre-midiseno-33x60','flpd-nombre-love-33x60','flpd-nombre-fuerza-33x60','flpd-nombre-hogar-33x60'];
    //Los SKU asociados a los Felpudo_40x70
    $allowed_skus_Felpudo_40x70 = ['Felp_Pedro40x70','flpd-nombre-bienv-40x70','fel-flia3-2mascota-40x70-','fel-flia6-40x70','fel-soltero-hijo-40x70','fel-pareja-mascota-40x70-',
                                   'fel-soltero-mascota-40x70','fel-flia5-mascota-40x70','fel-flia3-mascota-40x70','fel-flia4-mascota-40x70','fel-fliapareja-40x70',
                                   'fel-pareja-2mascota-40x70','fel-flia3-40x70','fel-pareja-3mascota-40x70','fel-flia4-2mascota-40x70','fel-flia4-40x70','fel-flia5-40x70',
                                   'flpd-fliapareja-perrogat-40x70','flpd-flia5-40x70','flpd-flia3-40x70','flpd-fliapareja-40x70','flpd-flia4-40x70','flpd-flia4-perrogato-40x70',
                                   'flpd-flia3-perrogato-40x70','flpd-nombre-midiseno-40x70','flpd-nombre-love-40x70','flpd-nombre-hogar-40x70','flpd-nombre-fuerza-40x70'];
    //Los SKU asociados a los Felpudo_60x100
    $allowed_skus_Felpudo_60x100 = ['Felp_Pedro60x100','fel-pareja-3masc-60x100','fel-flia3-2mascota-60x100','fel-flia6-60x100','fel-fliapareja-60x100','fel-soltero-hijo-60x100',
                                    'fel-flia4-2mascota-60x100', 'fel-flia3-60x100','fel-flia4-mascota-60x100','fel-pareja-2mascota-60x100','fel-flia5-mascota-60x100',
                                    'fel-flia5-60x100','fel-soltero-mascota-60x100','fel-flia3-mascota-60x100','fel-pareja-mascota-60x100','fel-flia4-60x100','flpd-flia3-60x100',
                                    'flpd-flia5-60x100','flpd-nombre-midiseno-60x100','flpd-flia3-perrogato-60x100','flpd-flia4-perrogato-60x100','flpd-fliapareja-perrogato-60x100',
                                    'flpd-nombre-hogar-60x100','flpd-nombre-love-60x100','flpd-nombre-iniciales-60x100','flpd-nombre-fuerza-60x100','flpd-nombre-bienvenidos-60x100'];

    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    $allowed_skus_Tazas_Magica = ['2153','2156-foto', '2153-dia-madre-mejorabuela',];

    $allowed_skus_Tazas_Magica_San_Valentin = [''];

    $allowed_skus_Tazas_Magica_Madre = ['2153-dia-madre-gracias','2153-dia-madre-felicidades','2153-dia-madre-mejormama','2153-dia-madre-casamama','2153-dia-madre-encasa',
                                        '2153-dia-madre-chupetemama','2153-dia-madre-mami','2153-dia-madre-mama-mejor','2153-dia-madre-coñazo-foto','2153-dia-madre','2153-dia-madre-100%',
                                        '2153-dia-madre-siempre-juntas','2153-dia-madre-mejormadre','2153-dia-madre-escudo','2153-dia-madre-coñazo-diseño','2153-dia-madre-mama-increible',
                                        '2153-dia-madre-escrito','2153-dia-madre-flores','2153-dia-madre-mandona','2153-dia-madre-orfanato','2153-dia-madre-mama-caña'];

    $allowed_skus_Tazas_Magica_Padre = ['044500001-midis-','2153-papa','2153-papa-todo','2153-padre-encasa','2153-papa-mejor','2153-padre-chupetepapa','2153-papa-mundo','2153-papa-gracias',
                                        '2153-padre-mejorpapa','2153-padre-felicidades','2153-padre-100%','2153-padre-casapapa','2153-padre-escrito','2153-padre-mejorabuelo',
                                        '2153-padre-mogollon'];

    $allowed_skus_Jarra_Cerveza = ['044500001-midis-'];

    $allowed_skus_Tazas_equipos = ['679-equipos-athletic', '679-equipos-madrid', '679-equip-girona', '679-equipos-atmadrid', '679-equipos-rsociedad', '679-equipos-barca', '679-equipos-betis',
                                   '679-equipos-sevilla', '679-equip-valencia', '679-equip-celta', '679-equip-granada', '679-equip-villareal', '679-equip-cadiz', '679-equip-espanyol','679-equipos'];

    $allowed_skus_Taza_Mosqueton_Rojo = ['1511-rojo-1'];
    $allowed_skus_Taza_Mosqueton_Negro = [''];

    $allowed_skus_Tazas_Blanco = ['679-blanco'];
    $allowed_skus_Tazas_Blanco_Pride = ['']; 
    $allowed_skus_Tazas_Blanco_Madre = ['']; 
    $allowed_skus_Tazas_Blanco_Padre = [''];
    $allowed_skus_Tazas_Blanco_con_Tapa = [''];
    $allowed_skus_Tazas_Blanco_San_Valentin = [''];
    
    $allowed_skus_Tazas_Granate = ['679tazacolget-granate'];

    $allowed_skus_Tazas_Verde_Claro = [];
    $allowed_skus_Tazas_Verde_Oscuro = ['679tazacolget-verdeoscuro'];

    $allowed_skus_Tazas_Negro = ['679-negro-1', '679tazacolget-negro'];

    $allowed_skus_Tazas_Azul_Celeste = ['679-azul-claro','679tazags-azul-claro']; 
    $allowed_skus_Tazas_Azul_Oscuro = ['679tazacolget-azuloscuro'];  

    
    $allowed_skus_Getsingular_Taza_Girona_F = [''];

    $allowed_skus_Tazas_Rojo = ['679tazacolget-rojo'];

    $allowed_skus_Tazas_Rosa = ['679-rosa', '679tazacolget-rosa']; 

    $allowed_skus_Tazas_Naranja = ['679tazacolget-naranja'];
    
    $allowed_skus_Tazas_Amarillo = ['679tazacolget-amarillo'];

    $allowed_skus_Taza_Iniciales_Middle = ['']; 

    $allowed_skus_Tazas_Pendiente_Clasificar = ['936-nombre-nommedio'];

    $allowed_skus_Tazas_Plastico_Infantil = ['']; 

    
    /* Estas dos tazas fueron previamente categorizadas como Otros_Productos -> Buscar sus SKUs */
    $allowed_skus_Getsingular_Taza_Granada_ = [''];
    $allowed_skus_Getsingular_Taza_RCD_Espa = ['']; 
    
    
    
    /* '936-nombre-nomdebajo','936-nombre-nommedio','936-nombre',,'936-madre-mejormadre2','936-madre-orfanato',
,'Taza_Diadelamadre_PC2'
'2153-tq-fotorosa','2153-poll', '2153-tq-sisi', '2153-polaroid-vida', '2153-infinito', '2153-love', '2153-marco-cor', '2153-tq-fotorojo', 
                                '2153-mejor-negro', '2153-amorgana', '2153-lgtbi-cor', '2153-lgtbi-band', '2153-tq-fotoazul', '2153-likesinst', '2153-mejor-blanco', 
                                '2153-tq-fotogris', '2153-cupidos', '2153-mejor-azul', '2153-tq-nombres', '2153-amorfam', '2153-mejor-rosa', '2153-lgtbi-love-air', 
                                '2153-infinito-rosa'
    'Taza_Diadelamadre_PC','Taza_Diadelamadre_PC1','1293-blanco','049040012-rosa','049040012-amarillo','049040012-negro','049040012-azul'
    '049040012','679-pride-agender','679-pride-banderapride-foto'
    '679-pride-pansexual-foto'
    '679-pride-nobinario'
    '679-pride-nobinario-foto'
    '679-pride-bearflag'
    '679-pride-bisexual'
    '679-pride-lesbiana'
    '679-pride-transgenero-foto'
    '679-pride-bandera-foto'
    '679-pride-lesbiana-foto'
    '679-pride-bearflag-foto'
    '679-pride-bisexual-foto'
    '679-pride-transgenero'
    '679-pride-asexual-foto'
    '679-pride-asexual'
    '679-pride-intersexual'
    '679-pride-agender-foto'
    '679-pride-nuevabanderapride'
    '679-pride-intersexual-foto'
    '679-pride-pansexual'
    '2146-lgtbq-arcoiris'
    '2146-lgtbq-cor'
    '2146-lgtbq-tequiero'
    '2146-lgtbq-amorbueno'
    '2146-lgtbq-love'
    '2146-lgtbq-amorgana'
    '2146-lgtbq-corbandera'
    '2146-lgtbq-milcorazones'
    '2146-lgtbq-disenos'
    '2146-lgtbq-nombrebandera'
    '2146-lgtbq-lovesair'
    '679-pride-verde'
    '679-pride-bandera'
    '679-pride'
    '679-pride-amarillo'
    '679-pride-lila'
    '679-pride-naranja'
    '679-pride-azul'
    '679-pride-rojo'
    '936-getmama-increible'
    '936-getsiempre-juntas'
    '936-getmama-caña'
    '936-getmama-mejor'
    '936-madre-flores'
    '936-madre-mejorabuela'
    '936-madre-casamama'
    '936-madre-100%'
    '936-madre-mejormadre'
    '936-madre-chupete'
    '936-madre-escrito'
    '936-madre-felicidades'
    '936-madre-mandona'
    '936-allmama'
    '679tazacolget-verde', '679tazacolget-azul', , '679tazacolget',
    
    '75-LUQS-8DWY'
    '36-2UO2-N6XT'
    '679-49040004-plata'
     '565tazaplastico', '565tazaplastico-solluna'
    '565tazaplastico-indio'
    '565tazaplastico-clasezorro'
    '565tazaplastico-arcoiris'
    '565tazaplastico-conejito'
    '565tazaplastico-clasezebra'
    '936-abuela-scrapbook'
    '936-abuelos-escudo'
    '936-abuela-escudo'
    '936-abuelo-marco'
    '936-abuelo-scrapbook'
    '936-abuelo'
    '936-abuelo-mejorabuelo'
    '936-abuela-aro'
    '936-abuelo-mejorabuela'
    '936-abuelo-aro'
    '936-padre-mogollon'
    '936-padre-todomas'
    '936-padre-encasa'
    '936-padre-chupetepapa'
    '936-padre-mejorabuelo'
    '936-padre-mejorpapa'
    '936-padre-casapapa'
    '936-padre-gracias'
    '936-padre-rayas'
    '936-padre-papi'
    '936-padre-felicidades'
    '936-padre-escudo'
    '936-padre-escrito'
    '936-padre-100%'
    '679tazaasacorazon', '936-mejor-rosa', '936-tq-nombres', '936-poll', '936-marco-cor', 
    '936-infinitoro-rosa', '936-tq-fotorojo', '936-lgtbi-cor', '936-love-love', '936-amorfam', 
    '936-mejorazul', '936-mejor-blanco', '936-tq-sisi', '936-mejor-negro', '936-likesinst', 
    '936-amorsiempre', '936-infinito'
    '936-cupido', '936-sanval', '936-lgtb-band', '936-tq-fotorosa', '936-lgtbi-love-air', '936-polaroid-vida', 
    '936-tq-fotogris', '936-tq-fotoazul',  '2146get', '656-multicolor-3', '656-old school-3', '656-foxies-3', 
    '656-tropical-lover-3', '656-cactus-3'
    '656-abejas-3'
    '656-cat-lover-3'
    '936-foto-coñazo'
    '936-mama-escudo'
    '936-diseño-coñazo'
    '679-amarillo'
    '679-azuloscuro'
    '679-verdeoscuro'
    '679-rosa'
    '656-bipolar'
    '656-bipolar blanco'
    '656-color-verte'
    '656-trucho'
    '656-princesas-cuento'
    '656-miau-miau'
    '656-sonrie-confunde'
    '656-tiempo'
    '656-shh-youtube'
    '656-shh-netflix'
    '656-eheh'
    '656-maldia'
    '656-dia-importe'
    'tazas-frases (variante)'
    '679-verde-1'
    '679-azul-1'
    '679-rojo-1'
    '679-$P-1 (variante)'
    '2146'
*/

    $allowed_skus_Otros_Productos = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
            $fileName = $_FILES['excelFile']['name'];
            $fileTmpPath = $_FILES['excelFile']['tmp_name'];
            $fileSize = $_FILES['excelFile']['size'];
            $fileType = $_FILES['excelFile']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
                        
            if ($fileExtension == 'xlsx') {
                $reader = new Xlsx();
                $spreadsheet = $reader->load($fileTmpPath);
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray();
                        
                echo '<form action="" method="post">';
                echo '<table border="1">';
                echo '<tr><th>Seleccionar</th><th>Order ID</th><th>Item ID</th><th>SKU</th><th>Nombre del Producto</th><th>Tipo de Producto</th><th>Sub Tipo de Producto</th></tr>';
                foreach ($data as $index => $row) {
                    $sku = isset($row[10]) ? $row[10] : '';
                    $productType = '';
                    $subProductType = '';


                    //Se utiliza Else IF porque PHP no reconoce in_array en Switch Case
                    if (in_array($sku, $allowed_skus_spotify_base)) {
                        $productType = 'Placas Spotify';
                        $subProductType = 'Placa_Spotify_BASE';
                    } elseif (in_array($sku, $allowed_skus_spotify_luz)) {
                        $productType = 'Placas Spotify';
                        $subProductType = 'Placa_Spotify_Luz';
                    } elseif (in_array($sku, $allowed_skus_spotify_1llavero)) {
                        $productType = 'Placas Spotify';
                            $subProductType = 'Placa_Spotify_1llavero';
                    } elseif (in_array($sku, $allowed_skus_spotify_2llaveros)) {
                        $productType = 'Placas Spotify';
                        $subProductType = 'Placa_Spotify_2llaveros';
                    } elseif (in_array($sku, $allowed_skus_350_Blanco)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_350_Blanco';
                    } elseif (in_array($sku, $allowed_skus_350_Blanco_Diseno)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_350_Blanco_Diseno';
                    } elseif (in_array($sku, $allowed_skus_500_Blanco)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Blanco';
                    } elseif (in_array($sku, $allowed_skus_500_Blanco_Diseno)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Blanco_Diseno';
                    } elseif (in_array($sku, $allowed_skus_750_Blanco)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_750_Blanco';
                    } elseif (in_array($sku, $allowed_skus_750_Blanco_Diseno)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_750_Blanco_Diseno';
                    } elseif (in_array($sku, $allowed_skus_350_Plata)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_350_Plata';
                    } elseif (in_array($sku, $allowed_skus_500_Plata)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Plata';
                    } elseif (in_array($sku, $allowed_skus_500_Plata_Diseno)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Plata_Diseno';
                    } elseif (in_array($sku, $allowed_skus_750_Plata)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_750_Plata';
                    } elseif (in_array($sku, $allowed_skus_350_Verde)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_350_Verde';
                    } elseif (in_array($sku, $allowed_skus_500_Verde)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Verde';
                    } elseif (in_array($sku, $allowed_skus_500_Verde_Diseno)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Verde_Diseno';
                    } elseif (in_array($sku, $allowed_skus_750_Verde)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_750_Verde';
                    } elseif (in_array($sku, $allowed_skus_350_Lila)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_350_Lila';
                    } elseif (in_array($sku, $allowed_skus_500_Lila)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Lila';
                    } elseif (in_array($sku, $allowed_skus_750_Lila)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_750_Lila';
                    } elseif (in_array($sku, $allowed_skus_350_Amarillo)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_350_Amarillo';
                    } elseif (in_array($sku, $allowed_skus_500_Amarillo)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Amarillo';
                    } elseif (in_array($sku, $allowed_skus_500_Amarillo_Diseno)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Amarillo_Diseno';
                    } elseif (in_array($sku, $allowed_skus_750_Amarillo)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_750_Amarillo';
                    } elseif (in_array($sku, $allowed_skus_500_Rosa_Purpurina)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Rosa_Purpurina';
                    } elseif (in_array($sku, $allowed_skus_500_Cobre_Purpurina)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Cobre_Purpurina';
                    }elseif (in_array($sku, $allowed_skus_infantil_Rosa)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_infantil_Rosa';
                    } elseif (in_array($sku, $allowed_skus_infantil_Azul)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_infantil_Azul';
                    } elseif (in_array($sku, $allowed_skus_500_Plata_Purpurina)) {
                        $productType = 'Botellas';
                        $subProductType = 'Botellas_Agua_500_Plata_Purpurina';
                    } elseif (in_array($sku, $allowed_skus_Felpudo_33x60)) {
                        $productType = 'Felpudos';
                        $subProductType = 'Felpudo_33x60';
                    } elseif (in_array($sku, $allowed_skus_Felpudo_40x70)) {
                        $productType = 'Felpudos';
                        $subProductType = 'Felpudo_40x70';
                    } elseif (in_array($sku, $allowed_skus_Felpudo_60x100)) {
                        $productType = 'Felpudos';
                        $subProductType = 'Felpudo_60x100';
                    } elseif (in_array($sku, $allowed_skus_Otros_Productos)) {
                        $productType = 'Otros_Productos';
                        $subProductType = 'Otros_Productos';
                    }

                    
                        
                    if ($productType) {
                        echo '<tr>';
                        echo '<td><input type="checkbox" name="urls[]" value="' . htmlspecialchars($row[24]) . '"></td>';
                        echo '<td><input type="hidden" name="order_ids[]" value="' . (isset($row[0]) ? htmlspecialchars($row[0]) : '') . '">' . (isset($row[0]) ? $row[1] : '') . '</td>'; // Order ID
                        echo '<td><input type="hidden" name="item_ids[]" value="' . (isset($row[1]) ? htmlspecialchars($row[1]) : '') . '">' . (isset($row[1]) ? $row[1] : '') . '</td>'; // Item ID
                        echo '<td>' . $sku . '</td>'; // SKU
                        echo '<td>' . (isset($row[11]) ? $row[11] : '') . '</td>'; // Nombre
                        echo '<td><input type="hidden" name="product_types[]" value="' . $productType . '">' . $productType . '</td>'; // Tipo de Producto
                        echo '<td><input type="hidden" name="sub_product_types[]" value="' . $subProductType . '">' . $subProductType . '</td>'; // Sub Tipo de Producto
                        if (isset($row[24])) {
                            echo '<td><a href="' . htmlspecialchars($row[24]) . '" target="_blank">Descargar</a></td>';
                        } else {
                            echo '<td>URL no disponible</td>';
                        }
                        echo '</tr>';
                    }
                }
                echo '</table>';
                echo '<input type="submit" name="saveUrls" value="Guardar Seleccionados">';
                echo '</form>';
            } else {
                echo '<h3>El archivo subido no es un .xlsx válido.</h3>';
            }

        } elseif (isset($_POST['saveUrls']) && !empty($_POST['urls'])) {
            $urls = $_POST['urls'];
            $order_ids = $_POST['order_ids'];
            $item_ids = $_POST['item_ids'];
            $product_types = $_POST['product_types'];
            $sub_product_types = $_POST['sub_product_types'];
                        
            // Vaciar la tabla temporal
            $conn->query("TRUNCATE TABLE temp_urls");
                        
            // Insertar URLs en la tabla temporal
            foreach ($urls as $index => $url) {
                $url = $conn->real_escape_string($url);
                $orderId = $conn->real_escape_string($order_ids[$index]);
                $itemId = $conn->real_escape_string($item_ids[$index]);
                $productType = $conn->real_escape_string($product_types[$index]);
                $subProductType = $conn->real_escape_string($sub_product_types[$index]);
                $conn->query("INSERT INTO temp_urls (order_id, order_item_id, url, product_type, sub_product_type) VALUES ('$orderId', '$itemId', '$url', '$productType', '$subProductType')");
                                    }
                        
                echo '<h3>URLs guardadas correctamente en la base de datos.</h3>';
                echo '<form action="" method="post">';
                echo '<input type="submit" name="downloadUrls" value="Descargar Todos">';
                echo '</form>';
                        
        } elseif (isset($_POST['downloadUrls'])) {
            $zip = new ZipArchive();
            $zipFileName = 'descargas.zip';
            $zipFilePath = sys_get_temp_dir() . '/' . $zipFileName;
                        
            if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
                exit("No se puede abrir el archivo ZIP");
            }
                        
            $result = $conn->query("SELECT url, product_type, sub_product_type FROM temp_urls");
            while ($row = $result->fetch_assoc()) {
                $url = $row['url'];
                $productType = $row['product_type'];
                $subProductType = $row['sub_product_type'];
                $fileContents = file_get_contents($url);
                if ($fileContents !== FALSE) {
                    $pathInfo = pathinfo($url);
                    $fileName = $productType . '/' . $subProductType . '/' . $pathInfo['basename'];
                    $zip->addFromString($fileName, $fileContents);
                }
            }
                        
            $zip->close();
                        
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $zipFileName);
            header('Content-Length: ' . filesize($zipFilePath));
            readfile($zipFilePath);
            unlink($zipFilePath);
            exit();
        } else {
            echo '<h3>Error al subir el archivo.</h3>';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sublimet APP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style type="text/css">
        body {
            background: #f5f5f5;
            margin-top: 20px;
        }

        /*------- portfolio -------*/
        .project {
            margin: 15px 0;
        }

        .no-gutter .project {
            margin: 0 !important;
            padding: 0 !important;
        }

        .has-spacer {
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 30px;
        }

        .has-spacer-extra-space {
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 30px;
        }

        .has-side-spacer {
            margin-left: 30px;
            margin-right: 30px;
        }

        .project-title {
            font-size: 1.25rem;
        }

        .project-skill {
            font-size: 0.9rem;
            font-weight: 400;
            letter-spacing: 0.06rem;
        }

        .project-info-box {
            margin: 15px 0;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 5px;
        }

        .project-info-box p {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #d5dadb;
        }

        .project-info-box p:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        /* img {
            width: 100%;
            max-width: 100%;
            height: auto;
            -webkit-backface-visibility: hidden;
        } */

        .rounded {
            border-radius: 5px !important;
        }

        .btn-xs.btn-icon {
            width: 34px;
            height: 34px;
            max-width: 34px !important;
            max-height: 34px !important;
            font-size: 10px;
            line-height: 34px;
        }

        .btn-xs.btn-icon span,
        .btn-xs.btn-icon i {
            line-height: 34px;
        }

        .btn-icon.btn-circle span,
        .btn-icon.btn-circle i {
            margin-top: -1px;
            margin-right: -1px;
        }

        .btn-icon i {
            margin-top: -1px;
        }

        .btn-icon span,
        .btn-icon i {
            display: block;
            line-height: 50px;
        }

        a.btn,
        a.btn-social {
            display: inline-block;
        }

        .mr-5 {
            margin-right: 5px !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .btn-facebook,
        .btn-facebook:active,
        .btn-facebook:focus {
            color: #fff !important;
            background: #4e68a1;
            border: 2px solid #4e68a1;
        }

        .btn-circle {
            border-radius: 50% !important;
        }

        .project-info-box p {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #d5dadb;
        }

        p {
            font-family: "Barlow", sans-serif !important;
            font-weight: 300;
            font-size: 1rem;
            color: #686c6d;
            letter-spacing: 0.03rem;
            margin-bottom: 10px;
        }

        b,
        strong {
            font-weight: 700 !important;
        }

        .tituloweb {
            color: #0192bc;
        }

        .btn-success {
            background-color: #0192bc !important;
        }

        .btn-primary {
            background-color: #0192bc !important;
        }

        #log-textarea {
            width: 100%;
            height: 300px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            color: #FFFFFF;
            background-color: #333333;
            font-size: 16px;
            font-family: 'Courier New', Courier, monospace;
            resize: none;
            overflow: auto;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 6px 0 hsla(0, 0%, 0%, 0.2);
            outline: none;
        }

        #log-textarea:focus {
            box-shadow: 0 6px 10px 0 hsla(0, 0%, 0%, 0.3);
        }
        /* --------------------------------------------------------------------------------------------- */
        body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        }

        table.order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: center; /* Center text */
            background-color: #fff;
        }

        .order-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: center; /* Center text in header */
            font-weight: bold;
        }

        .order-table th,
        .order-table td {
            padding: 12px 15px;
            border: 1px solid #dddddd;
            text-align: center; /* Center text in cells */
        }

        .order-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        $order-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .order-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .order-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .order-table img {
            max-width: 100px;
            height: auto;
        }

        .order-table .actions {
            display: flex;
            justify-content: center; /* Center buttons */
            gap: 10px;
        }

        .order-table .actions button {
            padding: 5px 10px;
            border: none;
            background-color: #009879;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .order-table .actions button:hover {
            background-color: #007f63;
        }

        #select-all {
            margin-right: 5px;
        }

        .button-container {
            text-align: right;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            border: none;
            background-color: #009879;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .button-container button:hover {
            background-color: #007f63;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
</head>

<body>

    <div class="container">
        <section class=" text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="tituloweb">Sublimet App</h1>
                </div>
            </div>
        </section>
        
        <button onclick="location.href='index.php'">Volver al inicio</button><br><br>
        <button onclick="location.href='logout.php'">Cerrar Sesión</button><br>

        <h2>Seleccionar archivo (.xlsx)</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- <input type="file" name="excelFile" accept=".xlsx"> -->
                <input type="file" name="excelFile" accept=".xlsx">
                <br><br>
                <input type="submit" value="Subir">
            </form>

    </div>

</body>

</html>
