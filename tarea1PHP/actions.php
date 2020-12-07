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
    <body>
<?php

/*
     * En esta línea se inicializa la sesión donde se estará guardando la información a mostrar.
     */
    session_start();

    /*
     * Se pasa la matriz guardada en la sesión a la variable items.
     */
    $items=unserialize($_SESSION["items"]);

    /*
     * Se verifica si en el método post existe la variable deleteItem.
     * En caso de existir se manda a llamar el método removeItem.
     */
    if(isset($_POST["deleteItem"])){


        removeItem($_POST["deleteItem"]);

    }

    /*
     * En caso de no existir la variable deleteItem en el método post, se checa si existe la variable modifyItem.
     * En caso de existir se manda a llamar el método createForm.
     */
    elseif (isset($_POST["modifyItem"])){

        //Se manda a llamar la funcion createForm pasando por parametro la variable modifyItem del método post.
        createForm($_POST["modifyItem"],"");

    }

    /*
     * En caso de no existir la variable modifyItem en el método post, se checa si existe la variable addItem.
     * En caso de existir se manda a llamar el método createForm.
     */
    elseif(isset($_POST["addItem"])){

        /*
         * Se manda a llamar la funcion createForm pasando por parametro -1 para indicar que es un elemento que no existe
         * en el arreglo.
        */
        createForm(-1,"");
    }

    /*
     * En caso de no existir la variable addItem en el método post, se checa si existe la variable saveItem.
     * En caso de existir se manda a llamar el método saveItems.
     */
    elseif(isset($_POST["saveItem"])){

        //Se valida que item no este vacío.
        if($_POST["itemName"]==""){
            createForm(-1,"error");
        }
        else {
            //Se manda a llamar la funcion saveItems pasando por parametro la variable saveItem del método post.
            saveItems($_POST["saveItem"]);
        }
    }

    elseif(isset($_POST["return"])){
        //Se hace un redirect a la página principal.
        header( "Location: index.php" );
    }

    /*
     * Funcion removeItem que sirve para eliminar un elemento de la matriz basado en el indice
     * Parametro de Entrada: $index
     */
    function removeItem($index){

        //Se declara la variable global items.
        global $items;

        //Se elemina el elemento de la matriz en base al indice.
        unset($items[$index]);

        //Se manda a llamar la función saveInfo para guardar la información modifica en la sesión.
        saveInfo();
    }

    /*
     * Funcion createForm que sirve para generar el formulario en el cual se van a realizar las modificaciones al item.
     * Parametro de Entrada: $index
     */
    function createForm($index,$error){

        //Se declara la variable global items.
        global $items;

        //Se crea una variable boleana para validar si es un elemento nuevo o es un elemento existente en la matriz.
        $exist = ($index > -1);
        ?>
        <h1>Información del Inventario</h1>
        <form action="actions.php" method="post">
            <table id="inventory">
                <tr>
                    <td>Item *</td>
                    <td> <input type="text" id="itemName" name="itemName"
                                value="<?= /*Operador ternario para llenar el texto*/ $exist?$items[$index]["item"]:''?>">
                        <?php
                            //Se valida si hubo error o no en la forma.
                            if(!empty($error)){
                                echo '</td><td><h4>Item no puede ser vacio</h4>';
                            }?>
                    </td>
                </tr>
                <tr>
                    <td>Cantidad (Por defecto: 1)</td>
                    <td> <input type="text" id="itemQty" name="itemQty"
                                value="<?= /*Operador ternario para llenar el texto*/ $exist?$items[$index]["qty"]:''?>"></td>
                </tr>
                <tr>
                    <td>Precio(Por defecto: 1)</td>
                    <td> <input type="text" id="itemPrice" name="itemPrice"
                                value="<?= /*Operador ternario para llenar el texto*/ $exist?$items[$index]["price"]:''?>"></td>
                </tr>

            </table>
            <button value="<?=$index?>" name="saveItem" id="saveSubmit">Guardar cambios</button>
            <button value="" name="return" id="returnSubmit">Cancelar</button>
        </form>
        <?php
    }

    /*
     * Funcion saveItems que sirve para guardar la información agregada en el formulario.
     * Parametro de Entrada: $index
     */

    function saveItems($id){

        //Se declara la variable global items.
        global $items;


        /*
         * Se generar un arreglo con la información a agregar.
         * Se utiliza el método strtolower y ucfirst en ese orden. Para que todos los items tengan el mismo formato.
         * El formato es la primera letra del nombre del item es mayúscula y las demás es minuscula.
         */
        $newInfo = array(
            "item"=>ucfirst(strtolower($_POST["itemName"])),
            "qty"=>(empty($_POST["itemQty"])?1:$_POST["itemQty"]),
            "price"=>(empty($_POST["itemPrice"])?1:$_POST["itemPrice"]));

        //Se utiliza un switch para checar si el $id utilizado existe o no.
        switch($id){
            //ID -1 elemento nuevo que se agregara a la matriz.
            case -1:
                array_push($items,$newInfo);
                break;
            //Caso base donde se modificara el elemento existente de la matriz.
            default:
                $items[$id] = $newInfo;
        }
        //Se manda a llamar la función saveInfo para guardar la información modifica en la sesión.
        saveInfo();
    }

    /*
     * Funcion saveInfo que sirve para guardar la información en la sesión.
    */

    function saveInfo(){

        //Se declara la variable global items.
        global $items;

        //Se serializa el arreglo items y se guarda en la sesión.
        $_SESSION["items"]= serialize($items);

        //Se hace un redirect a la página principal.
        header( "Location: index.php" );
    }
    ?>
    </body>
</html>