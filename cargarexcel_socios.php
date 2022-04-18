<?php
$titulo = "Carga Excel";
include 'assets/php/header.php';

ini_set('memory_limit', '-1');
set_time_limit(900);

require('assets/PHPExcel/PHPExcel.php');
require 'assets/PHPExcel/PHPExcel/IOFactory.php';
require 'assets/PHPExcel/PHPExcel/Reader/Excel2007.php';
    //$productos = ProductoPrecioData::getAll();
    //$dato = new ExcelProductosData();
    $informacion = array();
    
    //$dato->limpiar();
    



  //var_dump($array);
  //exit;
 
 // if(isset($_FILES['xls']['name']))

 

if(isset($_FILES['xls']['name']))
    {

         $listaproductos = array();
        
         $fname = $_FILES['xls']['name'];
        
         $chk_ext = explode(".",$fname);

         $filename = $_FILES['xls']['tmp_name'];

        $objPHPExcel = PHPExcel_IOFactory::load($filename);
        $worksheet=$objPHPExcel->setActiveSheetIndex(0);
  

    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    //$highestRow         = 10;
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
   // $highestColumn      = 'E'; // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    //$highestColumnIndex = 5;


    //var_dump($highestColumn);
    //exit;
    //$nrColumns = ord($highestColumn);
                        
     

    //$cantidad_imagenes = count($objPHPExcel->getActiveSheet()->getDrawingCollection());
    $val = $worksheet->getCellByColumnAndRow(0, 1);
    $primer_titulo = $val->getCalculatedValue();

    $val= $worksheet->getCellByColumnAndRow(12, 1);
    $ultimo_titulo = $val->getCalculatedValue();

    $val= $worksheet->getCellByColumnAndRow(6, 1);
    $medio_titulo = $val->getCalculatedValue();



    $contador=0;
   /* for ($row = 2; $row <= $highestRow; ++ $row) 
    {
        $cell = $worksheet->getCellByColumnAndRow(1, $row);
        if($cell!='' or strlen($cell)!=0)
           $contador=$contador+1;
    } */ 


   /* If(trim($primer_titulo)!="MARCA" or trim($ultimo_titulo)!="DATASHEET" or $cantidad_imagenes!=$contador)
    {
                $objPHPExcel->disconnectWorksheets();
                unset($objPHPExcel);
                Core::alert("Archivo: Formato de Archivo Invalido!");
                echo "<script type='text/javascript'>";
                echo "window.history.back(-1)";
                echo "</script>";
                exit;
    }*/

  if($highestColumnIndex==13 and trim($primer_titulo)=="Nrosocio" and trim($ultimo_titulo)=="categoriasocio" and trim($medio_titulo)=="Fnacimiento")
  {
                /*$objPHPExcel->disconnectWorksheets();
                unset($objPHPExcel);

            
                 echo "<script type='text/javascript'>";
                 echo "alert('Archivo: Formato de Archivo Invalido!')";
                 echo "window.history.back";
                 echo "</script>";
                 exit;*/
                
       


     for ($row = 2; $row <= $highestRow; ++ $row) 
     {   
          for ($col = 0; $col < $highestColumnIndex; ++ $col) {
             
               $cell = $worksheet->getCellByColumnAndRow($col, $row);
               if($col==0 && ($cell=='' or strlen($cell)==0))
                   //continue 2;
                     break;
             if($cell->isMergeRangeValueCell()==false)
             {
               //$val = $cell->getValue();
              
               $val = $cell->getCalculatedValue();

               
               $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
                                    
               //Suele pasarse de la cantidad de row y aparecen registros en blanco
               //compruebo que no este vacia la variable $val
              
                  //Si la columna es un numero, ajusto el valor con 3 decimales
                  //ustedes pueden poner los decimales que necesiten.
                  //n=Numerico
                  //s=String
                  

                  if($dataType=='n')
                  {
                    /* $valor=number_format($val,2,'.','');
                  }else{*/
                     $valor=intval($val);
                  }  

                  


                  if($dataType=='s')
                  {
                    /* $valor=number_format($val,2,'.','');
                  }else{*/
                     $valor=trim($val);
                  }  

                 
                  if($col==6)
                  {
                    $fecha=explode(' ',$val);
                    $valor=$fecha[0];

                      // $valor=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($val));
                     
                  }  

                  if($col==7)
                  {
                    $fecha=explode(' ',$val);
                    $valor=$fecha[0];
                    //$valor=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($val));
                  }  


                  if($col==11)
                  {
                    $fecha=explode(' ',$val);
                    $valor=$fecha[0];
                    //$valor=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($val));
                   
                  }  



                   if (isset($valor))
                       $informacion[$col]=$valor;
                   else 
                       $informacion[$col]=""; 

                                                
                  /*if(empty($datos))
                  {
                       $datos.="'$valor'";
                   }else{
                       $datos.=",'$valor'";
                   }   */
               // }   
               } 

                //$contador++;
            }    
            
             
            // exit;


            //---------------------------------------------------------------------------------


           if(count($informacion)>0)
           {

            //$cuotas=NULL;
            //$productos= $producto->getByName(trim($listaproductos[$i]['nombre']),trim($listaproductos[$i]['marca']));
            //$modelo = trim($informacion[2]);
            //$productos= $producto->getByModelo($modelo);

           
             //$existe =  check_socio($informacion[3]);
             $existe = check_socio_nro($informacion[0]);

             if($existe==true)
             {  
              
                  $socio = $informacion[0];

                  $nombre_completo = explode(' ', trim($informacion[1]));
               
                  $apellido = strtoupper($nombre_completo[0]);

                  //$nombre = strtoupper($nombre_completo[1]);
                  $nombre='';

                   if(isset($nombre_completo[1]))
                      $nombre=strtoupper($nombre_completo[1]);

                  if(isset($nombre_completo[2]))
                      $nombre.= ' '.strtoupper($nombre_completo[2]);

                  $dni = $informacion[2];

                  $sexo= NULL;

                   if(trim($informacion[3]) =='M')
                     $sexo= 1;
                   else if(trim($informacion[3]) =='F')
                     $sexo = 2;

                 // $direccion=htmlentities(addslashes($informacion[4]),ENT_NOQUOTES);
                  $direccion=$informacion[4];  

                  $telefono = $informacion[5];

                  $fecha_nacimiento = $informacion[6];

                  $fecha_ingreso = $informacion[7];

                  $cantidad_cuotas = $informacion[8];

                  $celular = $informacion[9];

                  $email = $informacion[10];

                  $baja = $informacion[11];

                  $categoria = $informacion[12];

                  /**************************************/
                  if($baja > '1900-01-01')
                    $estado = 2;
                  else
                    $estado = 1;
                  /**************************************/

  
                 alta_socio_excel($socio,$apellido, $nombre, $dni,  $fecha_nacimiento, $fecha_ingreso, $telefono, $celular, $email, $sexo, $direccion,$estado, $cantidad_cuotas ,0, 0);

                  //var_dump($informacion);
                  //exit;
                
                  
               /*  $PATH = "C:/fotos";
                 $MIME = "image/jpg";
                 $NAME = $socio.'.jpg';


                 $image = addslashes(file_get_contents("$PATH/$NAME"));

                 if(isset($image))
                      $sql = "INSERT INTO " . get_db() . ".imagen (i_socio, i_name, i_mime, i_data) VALUES ('{$socio}', '{$NAME}', '{$MIME}', '{$image}')";*/

          
              }
              else
              {

                 $socio = $informacion[0];

                 $telefono = $informacion[5];

                 $celular = $informacion[9];

                 $cantidad_cuotas = $informacion[8];

                 $baja = $informacion[11];

                 if($baja > '1900-01-01')
                   $estado = 2;
                 else
                   $estado = 1;

                  update_estado_($socio, $estado, $telefono, $celular, $cantidad_cuotas);

                 // $producto->actualizar();

              } 

            }  //End for
            
      
        } //End if 

         

     

  $objPHPExcel->disconnectWorksheets();
  unset($objPHPExcel);
    echo "<script type='text/javascript'>";
      echo "alert('Actualización exitosa!')";
    echo "</script>";
   //Core::alert("Actualización exitosa!");

   }//End if
     else
    {
       echo "<script type='text/javascript'>";
         echo "alert('Archivo invalido!')";
       echo "</script>";
             //Core::alert("Archivo invalido!");
    }   

  }
  else
    {
       echo "<script type='text/javascript'>";
         echo "alert('Archivo invalido!')";
       echo "</script>";
             //Core::alert("Archivo invalido!");
    }        
 


    //exit;
     
   echo "<script type='text/javascript'>";
      echo "window.history.back(-1)";
    echo "</script>";

?>

