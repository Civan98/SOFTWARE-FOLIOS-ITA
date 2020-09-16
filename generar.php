<?php 
    $cantidad=$_POST['cantidad'];
   // echo $cantidad;

    for ($i =1; $i<=$cantidad;$i++){
        GenerarFolio(); 
    }

    function GenerarFolio(){

        for ($i = 1; $i <= 2; $i++) {
            $folio1 = rand(0,9);
            $folio2 = rand(0,9);
        }

        $folio = date("d").date("m").date("o").$folio1.$folio2;
        echo "Folio ".$folio."<br>";
    }

?>