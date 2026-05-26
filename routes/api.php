<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    EntrenadorController,
    PlanController,
    QuestionnaireController,
    PanelClienteController,
    ClienteGestionController,
    plantillaEntrenamientoController,
    DietaController,
    JournalController,
    ProgresoController,
    PagoController,
    EntrenadorReviewController,
    BloqueController,
    MicrocicloController,
    EntrenoController,
    EjercicioController,
    SerieEjercicioController,
    EntrenadorPanelController,
    InvitacionController
};

// --- RUTAS PÚBLICAS ---
Route::get('/entrenadores', [EntrenadorController::class, 'index']);
Route::get('/planes', [PlanController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->post('/invitaciones/enviar', [InvitacionController::class, 'enviar']);
// --- RUTAS PROTEGIDAS ---
Route::middleware('auth:sanctum')->group(function () {

    // --- USUARIO ---
    Route::get('/user', fn(Request $request) => $request->user());

    // --- CUESTIONARIO ---
    Route::post('/cuestionario', [QuestionnaireController::class, 'store']);
    Route::get('/cuestionario/check', [QuestionnaireController::class, 'check']);


    // --- CLIENTE ---
    Route::prefix('cliente')->group(function () {

        Route::get('/panel', [PanelClienteController::class, 'index']);

        Route::get('/solicitudes', [EntrenadorPanelController::class, 'solicitudesPendientes']);
        Route::post('/solicitud/{id}/respuesta', [EntrenadorPanelController::class, 'responderSolicitud']);

        Route::get('/dieta/activa', [DietaController::class, 'dietaActiva']);

        Route::post('/journal', [JournalController::class, 'crear']);
        Route::get('/journal/historial', [JournalController::class, 'historial']);

        // --- PROGRESO ---
        Route::prefix('progreso')->group(function () {
            Route::post('/peso', [ProgresoController::class, 'registrarPeso']);
            Route::post('/medidas', [ProgresoController::class, 'registrarMedidas']);
            Route::post('/foto', [ProgresoController::class, 'registrarFoto']);
            Route::get('/historial', [ProgresoController::class, 'historial']);
            Route::get('/ultimos', [ProgresoController::class, 'ultimosDatos']);
        });
    });


    // --- ENTRENADOR ---
    Route::prefix('entrenador')->group(function () {

        // --- DASHBOARD ---
        Route::get('/dashboard', [EntrenadorPanelController::class, 'dashboard']);
        Route::get('/cliente/{id}', [ClienteGestionController::class, 'detalleCliente']);
        Route::get('/user/{id}', fn($id) => \App\Models\User::findOrFail($id));

        // --- PLANTILLAS ENTRENAMIENTO ---
        Route::prefix('plantillas/entrenamiento')->group(function () {
            Route::post('/', [plantillaEntrenamientoController::class, 'store']);
            Route::get('/', [plantillaEntrenamientoController::class, 'index']);
            Route::get('/{id}', [plantillaEntrenamientoController::class, 'show']);
            Route::put('/{id}', [plantillaEntrenamientoController::class, 'update']);
            Route::delete('/{id}', [plantillaEntrenamientoController::class, 'destroy']);
            Route::post('/{id}/asignar', [plantillaEntrenamientoController::class, 'asignarPlantilla']);
        });

        // --- PLANTILLAS DIETA ---
        Route::prefix('plantillas/dieta')->group(function () {
            Route::post('/', [DietaController::class, 'storePlantilla']);
            Route::get('/', [DietaController::class, 'indexPlantillas']);
            Route::get('/{id}', [DietaController::class, 'showPlantilla']);
            Route::put('/{id}', [DietaController::class, 'updatePlantilla']);
            Route::delete('/{id}', [DietaController::class, 'destroyPlantilla']);
            Route::post('/{id}/asignar', [DietaController::class, 'asignarPlantilla']);
        });

        // --- GESTIÓN DIETAS ---
        Route::prefix('dieta')->group(function () {
            Route::post('/crear', [DietaController::class, 'crearDieta']);
            Route::post('/comida', [DietaController::class, 'agregarComida']);
            Route::post('/comida/{id}/duplicar', [DietaController::class, 'duplicarComida']);
            Route::post('/opcion', [DietaController::class, 'agregarOpcion']);
            Route::put('/opcion/{id}', [DietaController::class, 'editarOpcion']);
        });

        // --- ALIMENTOS ---
        Route::get('/alimentos', [AlimentoController::class, 'search']);

        // --- SOLICITUDES ---
        Route::post('/solicitud', [EntrenadorPanelController::class, 'enviarSolicitud']);

        // --- BLOQUES ---
        Route::get('/bloque/plantilla/{plantillaId}', [BloqueController::class, 'buscarPorPlantilla']);
        Route::post('/bloque/crear', [BloqueController::class, 'crear']);
        Route::get('/bloque/{id}', [BloqueController::class, 'mostrar']);
        Route::put('/bloque/editar/{id}', [BloqueController::class, 'editar']);
        Route::delete('/bloque/eliminar/{id}', [BloqueController::class, 'eliminar']);

        // --- MICROCICLOS ---
        Route::post('/microciclo/crear', [MicrocicloController::class, 'crear']);
        Route::get('/microciclo/listar/{bloqueId}', [MicrocicloController::class, 'listar']);
        Route::put('/microciclo/editar/{id}', [MicrocicloController::class, 'editar']);
        Route::delete('/microciclo/eliminar/{id}', [MicrocicloController::class, 'eliminar']);
        Route::post('/microciclo/{id}/duplicar', [MicrocicloController::class, 'duplicar']);

        // --- ENTRENOS ---
        Route::post('/entreno/crear', [EntrenoController::class, 'crear']);
        Route::get('/entreno/listar/{microId}', [EntrenoController::class, 'listar']);
        Route::put('/entreno/editar/{id}', [EntrenoController::class, 'editar']);
        Route::delete('/entreno/eliminar/{id}', [EntrenoController::class, 'eliminar']);
        Route::post('/entreno/{id}/duplicar', [EntrenoController::class, 'duplicar']);

        // --- EJERCICIOS ---
        Route::post('/ejercicio/crear', [EjercicioController::class, 'crear']);
        Route::put('/ejercicio/editar/{id}', [EjercicioController::class, 'editar']);
        Route::delete('/ejercicio/eliminar/{id}', [EjercicioController::class, 'eliminar']);

        // --- SERIES ---
        Route::post('/serie/crear', [SerieEjercicioController::class, 'crear']);
        Route::put('/serie/editar/{id}', [SerieEjercicioController::class, 'editar']);
        Route::delete('/serie/eliminar/{id}', [SerieEjercicioController::class, 'eliminar']);


        // --- PENDIENTE DE IMPLEMENTAR ---

        /*
        // --- INGRESOS ---
        Route::prefix('ingresos')->group(function () {
            Route::get('/', [PagoController::class, 'ingresos']);
            Route::get('/historial', [PagoController::class, 'historialPagos']);
            Route::post('/registrar', [PagoController::class, 'registrarPago']);
        });

        // --- RESEÑAS ---
        Route::post('/review', [EntrenadorReviewController::class, 'crearReview']);
        Route::get('/{trainer_id}/reviews', [EntrenadorReviewController::class, 'verReviews']);
        Route::get('/{trainer_id}/rating', [EntrenadorReviewController::class, 'ratingEntrenador']);
        Route::put('/review/{id}', [EntrenadorReviewController::class, 'editarReview']);
        Route::delete('/review/{id}', [EntrenadorReviewController::class, 'eliminarReview']);
        */

    });
});