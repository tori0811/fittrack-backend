<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dieta;
use App\Models\JournalEntry;
use App\Models\ProgresoPeso;
use App\Models\ProgresoMedidas;
use App\Models\ProgresoFoto;
use App\Models\FraseMotivacional;
use App\Models\Bloque;
use Illuminate\Support\Facades\Log;

class PanelClienteController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();


            // -------------------------------------------------------
            // 1. FRASE MOTIVACIONAL DEL DÍA
            // -------------------------------------------------------
            $totalFrases = FraseMotivacional::where('activa', true)->count();

            if ($totalFrases > 0) {
                $indice = intval(date('z')) % $totalFrases;

                $fraseDelDia = FraseMotivacional::where('activa', true)
                    ->skip($indice)
                    ->first();
            } else {
                $fraseDelDia = (object)[
                    "frase" => "Construyendo tu mejor versión, día a día.",
                    "autor" => "FitTracker"
                ];
            }


            // -------------------------------------------------------
            // 2. ENTRENADOR ASIGNADO
            // -------------------------------------------------------
            $trainerUser = $user->assignedTrainer()->first();
            $trainerProfile = $trainerUser?->entrenador;

            $entrenador = null;

            if ($trainerUser) {
                $entrenador = [
                    'id' => $trainerUser->id,
                    'name' => $trainerUser->name,
                    'email' => $trainerUser->email,
                    'especialidad' => $trainerProfile->especialidad ?? null,
                    'experiencia' => $trainerProfile->experiencia ?? null,
                ];
            }


            // -------------------------------------------------------
            // 3. CUESTIONARIO
            // -------------------------------------------------------
            $cuestionario = $user->cuestionario()->first();


            // -------------------------------------------------------
            // 4. ENTRENAMIENTO DEL DÍA (NUEVO SISTEMA)
            // -------------------------------------------------------

            // Convertimos día del sistema → español
            $diaIngles = strtolower(now()->format('l'));

            $map = [
                'monday'    => 'Lunes',
                'tuesday'   => 'Martes',
                'wednesday' => 'Miércoles',
                'thursday'  => 'Jueves',
                'friday'    => 'Viernes',
                'saturday'  => 'Sábado',
                'sunday'    => 'Domingo',
            ];

            $hoy = $map[$diaIngles];

            // Buscar bloque activo
            $bloque = Bloque::where('user_id', $user->id)
                ->where('completado', false)
                ->with('microciclos.entrenos.ejercicios.series')
                ->first();

            $entrenoHoy = null;
            $progresoSemana = [
                'objetivo' => 0,
                'completados' => 0,
                'restantes' => 0
            ];

            if ($bloque) {

                $micro = $bloque->microciclos->where('completado', false)->first();

                if ($micro) {

                    // Entrenamiento del día según la semana
                    $entrenoHoy = $micro->entrenos->firstWhere('dia_semana', $hoy);

                    // Progreso semanal dentro del microciclo
                    $progresoSemana['objetivo'] = $micro->entrenos->count();

                    $progresoSemana['completados'] = $micro->entrenos
                        ->where('completado', true)
                        ->count();

                    $progresoSemana['restantes'] = max(
                        $progresoSemana['objetivo'] - $progresoSemana['completados'],
                        0
                    );
                }
            }


            // -------------------------------------------------------
            // 5. DIETA ACTIVA
            // -------------------------------------------------------
            $dieta = Dieta::where('user_id', $user->id)
                ->where('activa', true)
                ->with(['comidas.opciones'])
                ->first();


            // -------------------------------------------------------
            // 6. COMIDA SEGÚN LA HORA
            // -------------------------------------------------------
            $hora = intval(now()->format('H'));
            $comidaSugerida = null;

            if ($hora >= 7 && $hora < 10) {
                $comidaSugerida = "desayuno";
            } elseif ($hora >= 10 && $hora < 12) {
                $comidaSugerida = "almuerzo";
            } elseif ($hora >= 12 && $hora < 15) {
                $comidaSugerida = "comida";
            } elseif ($hora >= 16 && $hora < 18) {
                $comidaSugerida = "merienda";
            } elseif ($hora >= 19 && $hora < 22) {
                $comidaSugerida = "cena";
            }

            $comidaActual = null;

            if ($dieta && $comidaSugerida) {
                $comidaActual = $dieta->comidas()
                    ->where('tipo', $comidaSugerida)
                    ->with('opciones')
                    ->first();
            }


            // -------------------------------------------------------
            // 7. JOURNAL
            // -------------------------------------------------------
            $ultimoJournal = JournalEntry::where('user_id', $user->id)
                ->orderBy('fecha', 'desc')
                ->first();


            // -------------------------------------------------------
            // 8. PROGRESO FÍSICO
            // -------------------------------------------------------
            $ultimoPeso = ProgresoPeso::where('user_id', $user->id)
                ->orderBy('fecha', 'desc')
                ->first();

            $ultimasMedidas = ProgresoMedidas::where('user_id', $user->id)
                ->orderBy('fecha', 'desc')
                ->first();

            $ultimaFoto = ProgresoFoto::where('user_id', $user->id)
                ->orderBy('fecha', 'desc')
                ->first();


            // -------------------------------------------------------
            // 9. RESPUESTA FINAL
            // -------------------------------------------------------
            return response()->json([
                'user'=> $user,
                'frase_motivacional' => $fraseDelDia,
                'entrenador' => $entrenador,
                'entreno_hoy' => $entrenoHoy,
                'progreso_semanal' => $progresoSemana,
                'dieta_activa' => $dieta,
                'comida_sugerida' => $comidaSugerida,
                'comida_actual' => $comidaActual,
                'cuestionario' => $cuestionario,          
                'ultimo_journal' => $ultimoJournal,
                'ultimo_peso' => $ultimoPeso,
                'ultimas_medidas' => $ultimasMedidas,
                'ultima_foto' => $ultimaFoto,
            ]);

        } catch (\Throwable $e) {

            Log::error("Error en PanelClienteController: " . $e->getMessage());

            return response()->json([
                'error' => 'Hubo un problema al cargar el panel del cliente.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
