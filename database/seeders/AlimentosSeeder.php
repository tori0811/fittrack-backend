<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlimentosSeeder extends Seeder
{
    public function run(): void
    {
        $alimentos = [

            // -----------------------------------------------------
            // PROTEÍNAS
            // -----------------------------------------------------
            [ 'nombre' => 'Pavo', 'categoria' => 'proteina', 'proteinas' => 24, 'carbohidratos' => 0, 'grasas' => 1, 'kcal_por_100g' => 110 ],
            [ 'nombre' => 'Pollo', 'categoria' => 'proteina', 'proteinas' => 22, 'carbohidratos' => 0, 'grasas' => 3, 'kcal_por_100g' => 120 ],
            [ 'nombre' => 'Ternera', 'categoria' => 'proteina', 'proteinas' => 21, 'carbohidratos' => 0, 'grasas' => 5, 'kcal_por_100g' => 140 ],
            [ 'nombre' => 'Atún', 'categoria' => 'proteina', 'proteinas' => 23, 'carbohidratos' => 0, 'grasas' => 1, 'kcal_por_100g' => 109 ],
            [ 'nombre' => 'Claras de huevo', 'categoria' => 'proteina', 'proteinas' => 11, 'carbohidratos' => 0, 'grasas' => 0, 'kcal_por_100g' => 48 ],
            [ 'nombre' => 'Huevos', 'categoria' => 'proteina', 'proteinas' => 13, 'carbohidratos' => 1, 'grasas' => 11, 'kcal_por_100g' => 155 ],

            [ 'nombre' => 'Lomo embuchado', 'categoria' => 'proteina', 'proteinas' => 50, 'carbohidratos' => 1, 'grasas' => 12, 'kcal_por_100g' => 305 ],
            [ 'nombre' => 'Jamón serrano', 'categoria' => 'proteina', 'proteinas' => 30, 'carbohidratos' => 0, 'grasas' => 15, 'kcal_por_100g' => 241 ],
            [ 'nombre' => 'Queso fresco desnatado', 'categoria' => 'proteina', 'proteinas' => 10, 'carbohidratos' => 3, 'grasas' => 0, 'kcal_por_100g' => 60 ],
            [ 'nombre' => 'Yogur sin lactosa', 'categoria' => 'proteina', 'proteinas' => 5, 'carbohidratos' => 6, 'grasas' => 2, 'kcal_por_100g' => 60 ],
            [ 'nombre' => 'Yogur proteico', 'categoria' => 'proteina', 'proteinas' => 10, 'carbohidratos' => 4, 'grasas' => 0, 'kcal_por_100g' => 60 ],

            [ 'nombre' => 'Lomo', 'categoria' => 'proteina', 'proteinas' => 20, 'carbohidratos' => 0, 'grasas' => 5, 'kcal_por_100g' => 140 ],
            [ 'nombre' => 'Merluza', 'categoria' => 'proteina', 'proteinas' => 18, 'carbohidratos' => 0, 'grasas' => 1, 'kcal_por_100g' => 85 ],
            [ 'nombre' => 'Lenguado', 'categoria' => 'proteina', 'proteinas' => 20, 'carbohidratos' => 0, 'grasas' => 2, 'kcal_por_100g' => 95 ],
            [ 'nombre' => 'Lubina', 'categoria' => 'proteina', 'proteinas' => 21, 'carbohidratos' => 0, 'grasas' => 4, 'kcal_por_100g' => 124 ],
            [ 'nombre' => 'Carne picada de pollo', 'categoria' => 'proteina', 'proteinas' => 19, 'carbohidratos' => 0, 'grasas' => 8, 'kcal_por_100g' => 150 ],
            [ 'nombre' => 'Hamburguesas de pollo', 'categoria' => 'proteina', 'proteinas' => 18, 'carbohidratos' => 3, 'grasas' => 6, 'kcal_por_100g' => 140 ],


            // -----------------------------------------------------
            // CARBOHIDRATOS
            // -----------------------------------------------------
            [ 'nombre' => 'Arroz', 'categoria' => 'carbohidrato', 'proteinas' => 2.7, 'carbohidratos' => 28, 'grasas' => 0.3, 'kcal_por_100g' => 130 ],
            [ 'nombre' => 'Pasta', 'categoria' => 'carbohidrato', 'proteinas' => 5, 'carbohidratos' => 30, 'grasas' => 1, 'kcal_por_100g' => 157 ],

            [ 'nombre' => 'Copos de avena', 'categoria' => 'carbohidrato', 'proteinas' => 14, 'carbohidratos' => 60, 'grasas' => 7, 'kcal_por_100g' => 379 ],
            [ 'nombre' => 'Harina de avena', 'categoria' => 'carbohidrato', 'proteinas' => 13, 'carbohidratos' => 65, 'grasas' => 7, 'kcal_por_100g' => 400 ],

            [ 'nombre' => 'Pan de molde', 'categoria' => 'carbohidrato', 'proteinas' => 8, 'carbohidratos' => 49, 'grasas' => 4, 'kcal_por_100g' => 266 ],

            [ 'nombre' => 'Corn Flakes sin azúcar', 'categoria' => 'carbohidrato', 'proteinas' => 7, 'carbohidratos' => 84, 'grasas' => 0.5, 'kcal_por_100g' => 357 ],
            [ 'nombre' => 'Copos de trigo y arroz integral', 'categoria' => 'carbohidrato', 'proteinas' => 8, 'carbohidratos' => 78, 'grasas' => 2, 'kcal_por_100g' => 360 ],
            [ 'nombre' => 'Cereal mix sin azúcar', 'categoria' => 'carbohidrato', 'proteinas' => 9, 'carbohidratos' => 72, 'grasas' => 3, 'kcal_por_100g' => 340 ],
            [ 'nombre' => 'Weetabix', 'categoria' => 'carbohidrato', 'proteinas' => 12, 'carbohidratos' => 69, 'grasas' => 2, 'kcal_por_100g' => 360 ],

            [ 'nombre' => 'Tortitas de arroz', 'categoria' => 'carbohidrato', 'proteinas' => 8, 'carbohidratos' => 80, 'grasas' => 2, 'kcal_por_100g' => 387 ],
            [ 'nombre' => 'Tortitas de maíz', 'categoria' => 'carbohidrato', 'proteinas' => 7, 'carbohidratos' => 78, 'grasas' => 1, 'kcal_por_100g' => 370 ],

            [ 'nombre' => 'Avena crunchy 0%', 'categoria' => 'carbohidrato', 'proteinas' => 13, 'carbohidratos' => 64, 'grasas' => 6, 'kcal_por_100g' => 360 ],

            [ 'nombre' => 'Patata', 'categoria' => 'carbohidrato', 'proteinas' => 2, 'carbohidratos' => 17, 'grasas' => 0, 'kcal_por_100g' => 77 ],
            [ 'nombre' => 'Boniato', 'categoria' => 'carbohidrato', 'proteinas' => 1.6, 'carbohidratos' => 20, 'grasas' => 0, 'kcal_por_100g' => 86 ],
            [ 'nombre' => 'Ñoquis', 'categoria' => 'carbohidrato', 'proteinas' => 3.5, 'carbohidratos' => 35, 'grasas' => 0.5, 'kcal_por_100g' => 160 ],
            [ 'nombre' => 'Quinoa', 'categoria' => 'carbohidrato', 'proteinas' => 4.4, 'carbohidratos' => 21, 'grasas' => 2, 'kcal_por_100g' => 120 ],
            [ 'nombre' => 'Fajitas', 'categoria' => 'carbohidrato', 'proteinas' => 8, 'carbohidratos' => 50, 'grasas' => 4, 'kcal_por_100g' => 270 ],


            // -----------------------------------------------------
            // GRASAS
            // -----------------------------------------------------
            [ 'nombre' => 'Aceite de oliva', 'categoria' => 'grasa', 'proteinas' => 0, 'carbohidratos' => 0, 'grasas' => 100, 'kcal_por_100g' => 900 ],
            [ 'nombre' => 'Aguacate', 'categoria' => 'grasa', 'proteinas' => 2, 'carbohidratos' => 9, 'grasas' => 15, 'kcal_por_100g' => 160 ],
            [ 'nombre' => 'Mantequilla de cacahuete', 'categoria' => 'grasa', 'proteinas' => 25, 'carbohidratos' => 20, 'grasas' => 50, 'kcal_por_100g' => 588 ],


            // -----------------------------------------------------
            // SUPLEMENTOS
            // -----------------------------------------------------
            [ 'nombre' => 'Creatina', 'categoria' => 'suplemento', 'proteinas' => 0, 'carbohidratos' => 0, 'grasas' => 0, 'kcal_por_100g' => 0 ],
            [ 'nombre' => 'Proteína whey', 'categoria' => 'suplemento', 'proteinas' => 78, 'carbohidratos' => 10, 'grasas' => 4, 'kcal_por_100g' => 400 ],
            [ 'nombre' => 'Pre-entreno', 'categoria' => 'suplemento', 'proteinas' => 0, 'carbohidratos' => 5, 'grasas' => 0, 'kcal_por_100g' => 20 ],
        ];

        DB::table('alimentos')->insert($alimentos);
    }
}
