<html>
<?php
/*
Alumno: Enrique Manuel Gorian Lemus
Profesor: Octavio Aguirre Lozano
Materia: Computacion en el servidor Web
Trabajo: Desarrollo Web Avanzado
*/
?>
    <head>
        <link rel="stylesheet" href="styles.css">
    </head>
<?php
//En esta línea se inicializa la sesión donde se estará guardando la información a mostrar.
session_start();

/*
 * Se valida si el objeto items esta definido dentro de la sesión.
 * En caso que no se encuentre validado, se va a generar un arreglo con items predefinido que servira para llenar la
 * tabla que se mostrara.
*/
if(!isset($_SESSION["items"])){
    //Se crea la matriz items y se inicializa con arreglos predefinidos.
   $items =  array(
       array("item"=>"Lapiz","price"=>5,"qty"=>15),
       array("item"=>"Papel","price"=>40,"qty"=>14),
       array("item"=>"Boligrafo","price"=>50,"qty"=>10),
       array("item"=>"Calculadora","price"=>150,"qty"=>5),
       array("item"=>"Borrador","price"=>10,"qty"=>9),
       array("item"=>"Plumon","price"=>10,"qty"=>20),
       array("item"=>"Pizarron","price"=>300,"qty"=>1),
       array("item"=>"Tijeras","price"=>15,"qty"=>4),
       array("item"=>"Impresoras","price"=>2500,"qty"=>7),
       array("item"=>"Monitor","price"=>4000,"qty"=>8)
   );
   //Se serializa el arreglo items y se guarda en la sesión.
   $_SESSION["items"]=serialize($items);
} else {
    /*
     * En caso de existir el arreglo dentro de la sesión, se guarda la matriz en la variable items.
     */
    $items=unserialize($_SESSION["items"]);
}
?>

    <body>
    <h1>Tabla de inventario</h1>
    <form action="actions.php" method="post">
        <div>
            <button value="" name="addItem" id="newAddSubmit">Agregar Nuevo Item</button>
        </div>
        <br/>
        <table id="inventory">
            <tr>
                <th>Item</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Acción</th>
            </tr>
            <?php
            /*
             * Se crea un ciclo foreach para iterar por todos los items dentro de la matriz items y llenar la tabla
             * con la información a mostrar.
             * Se utiliza el formato $id=>$item con la finalidad de obtener el id de cada subarreglo para poder
             * utilizarlo cuando se quiera modificar la información.
             */
            foreach($items as $id=>$item){
                echo "<tr>";
                echo "<td>".$item["item"]."</td>";
                echo "<td>".$item["qty"]."</td>";
                echo "<td>".$item["price"]."</td>";
                echo "<td>";
                echo"<button value='".$id."' name='modifyItem' id='modifySubmit'>Modificar</input>";
                echo"<button value='".$id."' name='deleteItem' id='deleteSubmit'>Eliminar</input>";
                echo"</td>";
                echo "</tr>";
            }
            ?>
            </table>
        </form>
    </body>
</html>