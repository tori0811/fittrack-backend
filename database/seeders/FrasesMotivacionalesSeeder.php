<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FraseMotivacional;

class FrasesMotivacionalesSeeder extends Seeder
{
    public function run(): void
    {
        $frases = [
            ["frase" => "La disciplina es el puente entre metas y logros.", "autor" => "Jim Rohn"],
            ["frase" => "No tienes que ser el mejor, solo tienes que ser mejor que ayer.", "autor" => "Floyd Mayweather Jr."],
            ["frase" => "El dolor es temporal, la gloria es para siempre.", "autor" => "Lance Armstrong"],
            ["frase" => "Haz lo que puedas, con lo que tengas, donde estés.", "autor" => "Theodore Roosevelt"],
            ["frase" => "La fuerza no viene de la capacidad física, sino de la voluntad indomable.", "autor" => "Mahatma Gandhi"],
            ["frase" => "La acción es la clave fundamental para todo éxito.", "autor" => "Pablo Picasso"],
            ["frase" => "Si quieres algo que nunca tuviste, debes hacer algo que nunca hiciste.", "autor" => "Thomas Jefferson"],
            ["frase" => "El éxito es la suma de pequeños esfuerzos repetidos día tras día.", "autor" => "Robert Collier"],
            ["frase" => "No cuentes los días, haz que los días cuenten.", "autor" => "Muhammad Ali"],
            ["frase" => "El cuerpo logra lo que la mente cree.", "autor" => "Napoleon Hill"],
            ["frase" => "La constancia vence a lo que la suerte no alcanza.", "autor" => "Baltasar Gracián"],
            ["frase" => "Siempre parece imposible hasta que se hace.", "autor" => "Nelson Mandela"],
            ["frase" => "La motivación te impulsa a comenzar; el hábito te mantiene en marcha.", "autor" => "Jim Ryun"],
            ["frase" => "No hay atajos hacia ningún lugar que valga la pena.", "autor" => "Beverly Sills"],
        ];

        foreach ($frases as $f) {
            FraseMotivacional::create($f);
        }
    }
}
