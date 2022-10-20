<?php

// Definimos un array con las frases del juego
$frases = [
    "IES La Encanta",
    "La vida de Brian",
    "Java es divertido",
    "Matrix es una gran pelicula",
    "Ojo con el ajo",
    "Pirineos y Alpes",
    "Comunidad Valenciana",
    "Informatica es CS en ingles",
    "Africa y Europa",
    "Asia y America",
    "Chincheta",
    "Frigorifico",
    "Chimenea",
    "Rojales",
    "Rio Segura"
];

// Creamos una función que nos genere una frase enmascarada
function genEnmasc(string $frase): string
{
    $a = mb_str_split($frase);
    $frasEnmasc = "";
    foreach ($a as $i => $value) {
        if ($value == " ") {
            $frasEnmasc .= " ";
        } else {
            $frasEnmasc .= "_";
        }
    }
    return $frasEnmasc;
}

$i = rand(0, count($frases) - 1);
$frase = $frases[$i];
$fraseArray = mb_str_split($frase, 1, "UTF-8");
$enmasc = genEnmasc($frase);
$enmascArray = mb_str_split($enmasc, 1, "UTF-8");
$count = 6;

// Creamos otra función que nos permita mostrar las diferentes situaciónes del juego
function showInfo($count)
{
    switch ($count)
    {
        case 6:
            echo <<<_END
              ____
             |    |
             |
             |
             |
             |
            ---
            _END;
            break;
        case 5:
            echo <<<_END
              ____
             |    |
             |    O
             |
             |
             |
            ---
            _END;
            break;
        case 4:
            echo <<<_END
              ____
             |    |
             |    O
             |    |
             |
             |
            ---
            _END;
            break;
        case 3:
            echo <<<_END
              ____
             |    |
             |    O
             |    |\
             |
             |
            ---
            _END;
            break;
        case 2:
            echo <<<_END
              ____
             |    |
             |    O
             |   /|\
             |
             |
            ---
            _END;
            break;
        case 1:
            echo <<<_END
              ____
             |    |
             |    O
             |   /|\
             |   /
             |
            ---
            _END;
            break;
        case 0:
            echo <<<_END
              ____
             |    |
             |    O
             |   /|\
             |   / \
             |
            ---
            _END;
            break;
    }
}

// Con el bucle do while hacemos la mecánica del juego
do {
    showInfo($count); // Mostramos el estado del juego
    echo implode("", $enmascArray); // Mostramos la frase enmascarada
    echo "\n";
    $letra = readline("Dame una letra: "); // Pedimos una letra
    $numLetras = 0;

    // Con un if global comprobamos que se introduce una letra y no un número o frase
    if (ctype_alpha($letra) && mb_strlen($letra) == 1) {
        foreach ($fraseArray as $i => $v) {
            if (mb_strtolower($letra) == mb_strtolower($v)) {
                $enmascArray[$i] = $v; // Se sustituye la letra
                $numLetras++; // Se suma uno si es correcta la letra
            }
        }

        // Si la letra no es correcta se muestran los intentos que te quedan
        if ($numLetras == 0) {
            $count--;
            showInfo($count);
            echo "Has fallado, te quedan " . $count . " intentos. \n";
        } else {
            //echo implode("", $frasEnmasc) . "\n";
            $resolver = readline("¿Quieres resolver la frase?[S/N]: "); // Pedimos si quiere serolver
            // Se comprueba si es "Sí" o si es "No"
            if ($resolver == "S" || $resolver == 's') {
                $resuelto = readline("Resuelve: ");
                // Si la frase es correcta has ganado
                if ($resuelto == $frase) {
                    echo "\nHAS GANADO!!!";
                    break;
                } else { // De lo contrario se restan intentos
                    $count--;
                }
            }
        }
    } else {
        echo "Error, introduce un carácter válido. \n";
    }

} while ($enmascArray !== $fraseArray && $count > 0);

// Si ya no hay intentos, se pierde y se muetsra la frase
if ($count == 0) {
    showInfo($count);
    echo "Vaya! Has perdido. La frase era: $frase";
}