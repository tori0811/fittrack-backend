<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    public function entrenador() {

        return $this->hasOne(Entrenador::class, 'user_id');
    }

    public function profile() {

        return $this->hasOne(UserProfile::class);
    
    }

    public function userProfile()
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }


    public function assignedTrainer()
    {
        return $this->belongsToMany(
            User::class,
            'user_trainers',
            'user_id',      // cliente
            'trainer_id'    // entrenador (user.id)
        );
    }

    public function clientesAsignados()
    {
        return $this->belongsToMany(
            User::class,
            'user_trainers',
            'trainer_id',   // entrenador
            'user_id'       // cliente
        );
    }

    public function rutinas(){
        return $this->hasMany(Rutina::class, 'user_id');
    }

    public function rutinasAsignadas(){
        return $this->hasMany(Rutina::class, 'trainer_id');
    }


    public function dietaActiva() {
        return $this->hasOne(Dieta::class, 'user_id')->where('activa', true);
    }

    public function journal() {

        return $this->hasMany(JournalEntry::class, 'user_id');
    }

    public function progresoPeso() {

        return $this->hasMany(ProgresoPeso::class, 'user_id');
    }

    public function progresoMedidas() {

        return $this->hasMany(ProgresoMedidas::class, 'user_id');
    }

    public function progresoFotos() {

        return $this->hasMany(ProgresoFoto::class, 'user_id');
    }

    public function cuestionario() {
        return $this->hasOne(UserQuestionnaire::class, 'user_id');
    }

    public function trainerRequestsEnviadas()
    {
        return $this->hasMany(TrainerRequest::class, 'trainer_id');
    }

    public function trainerRequestsRecibidas()
    {
        return $this->hasMany(TrainerRequest::class, 'user_id');
    }

    public function pagosRecibidos()
    {
        return $this->hasMany(Pago::class, 'trainer_id');
    }

    public function pagosRealizados()   
    {
        return $this->hasMany(Pago::class, 'user_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
