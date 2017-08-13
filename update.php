<?php


// uso GDRIVE per deterimare dal portale CKAN Regionale l'ultimo CSV aggiornato e lo salvo in locale sul server ogni mezzanotte
//$indirizzo ="https://docs.google.com/spreadsheets/d/1a4SWZPbydFANIiTtFkBSWQZLWWQagFac7no5adST718/pub?gid=1896544534&single=true&output=csv";
//$homepage2 = file_get_contents($indirizzo);

$inizio=1;
$homepage ="";

  $csv1 = array_map('str_getcsv', file('db/ricettive.csv'));
  //$csv1 = array_map('str_getcsv', file('http://dati.umbria.it/datANTICHE MACINEe/dump/062d7bd6-f9c6-424e-9003-0b7cb3744cab'));

  $count=0;
  foreach($csv1 as $csv11=>$data1){
    $count1 = $count1+1;


    if ($count1 >1){


//  echo "Conversion: " . $pointDest->toShortString() . " in WGS84<br><br>";
    $features[] = array(
            'type' => 'Feature',
            'geometry' => array('type' => 'Point', 'coordinates' => array((float)$data1[16],(float)$data1[15])),
            'properties' => array('nome_comune' => $data1[13],'denominazione_struttura' => $data1[3], 'indirizzo' => $data1[9],'prov' => $data1[14],'classificazione' => $data1[5],'categoria' => $data1[4],'camere' => $data1[6],'web' => $data1[19],'tel' => $data1[17],'email' => $data1[20],'perdiodi'=>$data1[21],'servizi_generali'=>$data1[22],'servizi_camera'=>$data1[23],'prezzo_alta_stagione_o_unica'=>$data1[24],'prezzo_bassa_stagione'=>$data1[25],'foto1'=>$data1[26])
            );
  }
}
  $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
  $geostring=json_encode($allfeatures, JSON_PRETTY_PRINT);

//	$homepage1=str_replace(",",".",$homepage1); //le lat e lon hanno la , e quindi metto il .
//  $homepage1=str_replace(";",",",$homepage1); // converto il CSV da separatore ; a ,

  echo $geostring;
  $file = '/usr/www/piersoft/dovedormireinpugliabot/db/ricettive.json';

// scrivo il contenuto sul file locale.
  file_put_contents($file, $geostring);
//echo "finito";
?>
