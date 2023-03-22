<?php 
    /*  Descripcion del Ejercicio.
            EJERCICIO 1
            Usted está intentando abrir negocio de producción de leche, para ello necesita comprar vacas, cuando va a elegir las vacas se cruza con un problema, tiene a su disposición un camión con un cierto límite de peso, y un grupo de vacas disponibles para la venta. Cada vaca puede tener un peso distinto, y producir una cantidad diferente de leche al día.
            Su objetivo, es crear un programa que sea capaz de elegir automaticamente qué vacas comprar y llevar en su camión, de modo que pueda maximizar la producción de leche, sin sobrepasar el límite de peso del camión.
            Al finalizar la ejecución debe mostrar la cantidad máxima de leche que puede producir con las vacas seleccionadas.
            Para la información de entrada, tú decides como tomarla, puedes declarar variables con la información, leerlo de una base de datos, o simplemente tomarlo de la entrada estándar.


    */

    // Se declara un objeto donde se va obtener los datos que van a funcionar en el ejercicio, estos dantos tambien pueden ser traidos desde una consulta a una base de datos si es el caso. Se guardan en la variable $datosGlobales
    $datosGlobales = [
        "1" => [
            "1" => [
                "peso" => 360,
                "producLeche" => 40,
            ],
            "2" => [
                "peso" => 250,
                "producLeche" => 35,
            ],
            "3" => [
                "peso" => 400,
                "producLeche" => 43,
            ],
            "4" => [
                "peso" => 180,
                "producLeche" => 28,
            ],
            "5" => [
                "peso" => 50,
                "producLeche" => 12,
            ],
            "6" => [
                "peso" => 90,
                "producLeche" => 13,
            ],
            "pesoSoporta" => 700
                  
        ],
        "2" => [
            "1" => [
                "peso" => 223,
                "producLeche" => 30,
            ],
            "2" => [
                "peso" => 243,
                "producLeche" => 34,
            ],
            "3" => [
                "peso" => 100,
                "producLeche" => 28,
            ],
            "4" => [
                "peso" => 200,
                "producLeche" => 45,
            ],
            "5" => [
                "peso" => 200,
                "producLeche" => 31,
            ],
            "6" => [
                "peso" => 155,
                "producLeche" => 50,
            ],
            "7" => [
                "peso" => 300,
                "producLeche" => 29,
            ],
            "8" => [
                "peso" => 150,
                "producLeche" => 1,
            ],
            "pesoSoporta" => 1000
                  
        ],
        "3" => [
            "1" => [
                "peso" => 340,
                "producLeche" => 45,
            ],
            "2" => [
                "peso" => 355,
                "producLeche" => 50,
            ],
            "3" => [
                "peso" => 223,
                "producLeche" => 34,
            ],
            "4" => [
                "peso" => 243,
                "producLeche" => 39,
            ],
            "5" => [
                "peso" => 130,
                "producLeche" => 29,
            ],
            "6" => [
                "peso" => 240,
                "producLeche" => 40,
            ],
            "7" => [
                "peso" => 260,
                "producLeche" => 30,
            ],
            "8" => [
                "peso" => 155,
                "producLeche" => 52,
            ],
            "9" => [
                "peso" => 302,
                "producLeche" => 31,
            ],
            "10" => [
                "peso" => 130,
                "producLeche" => 1,
            ],
            "pesoSoporta" => 2000
                  
        ]
    ];


    foreach ($datosGlobales as $k => $valor) {
        $lecheTotalPosible = 0; // para cada caso que se recorra se inicializa la variable en 0 de la leche total posible
        $maxCamion = $valor["pesoSoporta"]; // Guarda la capacidad maxima del camion para el ejemplo que esta corriendo

        //se eleva el maximo de datos para obtener las posibles combinaciones 
        for ($i = 0; $i < pow(2, count($valor)); $i++) {
            $pesoAcum = 0; //inicializa en 0 el peso acumulado
            $maxLeche = 0; //inicializa en 0 el peso max de leche
            for ($j = 1; $j <= count($valor); $j++) {
                if (($i & (1 << ($j - 1))) != 0) {
                    $vaca = $valor[$j];
                    $pesoAcum += $vaca["peso"];
                    $maxLeche += $vaca["producLeche"];
                }
            }
            //si el peso total acumulado es menor o igual al total del peso del camion Y el total de produccion de leche es mayor al total anterior, entonces se va a guardar estos datos como la mejor combinacion posible 
            if ($pesoAcum <= $maxCamion && $maxLeche > $lecheTotalPosible) {
                $lecheTotalPosible = $maxLeche;
            }
        }
        echo "El ejemplo". $k ." daria un maximo de produccion de leche posible de: ". $lecheTotalPosible ." Litros\n\n";
    }
?>