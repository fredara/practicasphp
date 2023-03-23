<?php 
    
    /* 

        EJERCICIO 2
        Estás tratando de resolver un problema complejo. Para simplificar, lo has dividido en subtareas. La mayoría de estas subtareas se pueden ejecutar en paralelo, pero algunas son dependientes de la finalización de tareas previas. No hay límite en el número de tareas que se pueden ejecutar en paralelo. Cada tarea tiene un tiempo de duración asociado.

        Se te indicará un subconjunto de estas tareas. Para cada una de ellas, tendrás que responder cuál es el tiempo mínimo necesario para su resolución (debes tener en cuenta las dependencias entre tareas).

        Las relaciones entre las tareas se leerán desde un archivo txt con el siguiente formato:


        # Total de tareas
        n

        # Tiempo que toma cada tarea (x sería el número de tarea, tx sería el tiempo que toma la tarea)
        x, tx


        # Dependencias entre tareas (x tarea principal, x,y,z serían las posibles dependencias de la tarea x) : la resolución de la tarea x depende previamente de la solución de las tareas y, z, w
        x, y, z, w


        El resultado esperado debe estar en el formato: Identificador de tareas (espacio) tiempo necesario
        x, tx
        y, ty
        z, tz

        Nota: Si una tarea ya fue ejecutada por la dependencia de una tarea anterior, el tiempo de esta ya no deberá considerarse para la tarea actual.
        En el siguiente ejemplo la tarea “y” ya fue ejecutada por la tarea “x” por lo que ya no se contaría para el cálculo del tiempo de la tarea “z” puesto que está ya fue procesada con anterioridad.
        x, y
        z, y

        El contenido del archivo txt de ejemplo seria: 

        # Total de tareas
        6

        # Tiempo que toma cada tarea (tarea, tiempo)
        0,2
        1,3
        2,4
        3,9
        4,7
        5,9

        # Dependencias entre tareas (tarea, dependencias)
        0,4
        3,0,1,2
        4,5


    */

    $dataArchivo = $argv[1];

    function leerArchi($archivo) { 
        $tareas = array(); 
        $tiempos = array();
        $dependencias = array(); 
        $file = fopen($archivo, "r");
        $linea1 = fgets($file);
        $linea2 = fgets($file);

        $totalTareas = trim($linea2);


        $linea3 = fgets($file);$linea4 = fgets($file); // 


        // se guardar el tiempo que toma cada tarea en arreglos por separado 
        for ($i = 0; $i < $totalTareas; $i++) {
            $lineaN = fgets($file);
            $datos = explode(",", $lineaN); 
            //print_r($datos); echo "\n";
            $tarea = intval(trim($datos[0])); 
            $tiempo = intval(trim($datos[1])); 
            $tareas[$i] = $tarea; 
            $tiempos[$tarea] = $tiempo; 
        } 

        //Se guarda en un arreglo las dependencias por tarea
        $lineanew = fgets($file);$lineanew1 = fgets($file);
        while (!feof($file)) { 
            $linea = fgets($file); 
            $datos = explode(",", $linea); 
            $tarea = intval(trim($datos[0])); 
            $dependencias[$tarea] = array(); 
            for ($i = 1; $i < count($datos); $i++) { 
                $dep = intval(trim($datos[$i])); 
                $dependencias[$tarea][] = $dep; 
            } 
        } 

        fclose($file); 
        return array($tareas, $tiempos, $dependencias); 
    } 

    function ordenar($tarea, $dependencias, $visitados, $orden) { 
        $visitados[$tarea] = true;

        foreach ($dependencias[$tarea] as $dep) { 
            if (!$visitados[$dep]) { 
                ordenar($dep, $dependencias, $visitados, $orden); 
            } 
        } 
        
        array_push($orden, $tarea); 
        //print_r($orden);
        return $orden;
    } 

    function relacionTiemTare($tarea, $tareas, $dependencias, $tiempos) { 
        if (isset($tiempos[$tarea])) { 
            return $tiempos[$tarea]; 
        } 
        $tiempo = $tareas[$tarea]; 
        foreach ($dependencias[$tarea] as $dep) { 
            $tiempo += relacionTiemTare($dep, $tareas, $dependencias, $tiempos); 
        } 
        $tiempos[$tarea] = $tiempo; 
        return $tiempo; 
    } 



    function main($archivo) { 
        list($tareas, $tiempos, $dependencias) = leerArchi($archivo); 

        $visitados = array_fill(0, count($tiempos), false); 
        $orden = array(); 
        if(!empty($tareas)){
            foreach ($tareas as $tarea) { 
                if (!$visitados[$tarea]) { 
                    $orden = ordenar($tarea, $dependencias, $visitados, $orden); 
                } 
            } 
        }

        $orden = array_reverse($orden); 

        // Calcular el tiempo necesario para resolver cada tarea
        $tiemposResueltos = array(); 
        $resultado = array(); 
        foreach ($orden as $tarea) { 
            $tiempoCal = relacionTiemTare($tarea, $tiempos, $dependencias, $tiemposResueltos); 
            $resultado[] = array($tarea, $tiempoCal); 
        } 

        return $resultado; 
    } 


    $respuesta = main($dataArchivo);
    echo "El Resultado por tarea seria : \n";
    foreach ($respuesta as $tarea) {
        echo $tarea[0] . ", " . $tarea[1] . "\n";
    }
?>