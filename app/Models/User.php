<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;
use Throwable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function login($credentials)
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            throw new Exception('Credencias incorretas, verifique-as e tente novamente.', -404);
        }
        return $token;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function logout($token)
    {
        if (!JWTAuth::invalidate($token)) {
            throw new Exception('Erro. Tente novamente.', -404);
        }
    }

    public function index()
    {
        return self::orderBy('name')->get();
    }

    public function createOrUpdate($fields, $id = null)
    {
        try {
            DB::beginTransaction();
            if ($id) {
                $user = User::find($id);
            } else {
                $user = new User();
            }

            $user->name = $fields['name'];
            $user->email = $fields['email'];
            $user->password = !empty($fields['password']) ? Hash::make($fields['password']) : $user->password;
            $user->img = !empty($fields['img']) ? $fields['img'] : $user->img;
            $user->save();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $user;
    }

    public function show($id)
    {
        $show = self::selectRaw('id, name, email')
            ->where('id', '=', $id)
            ->first();

        if (!$show) {
            throw new Exception('Nada Encontrado', -404);
        }

        return $show;
    }

    public function remove($id)
    {
        try {
            DB::beginTransaction();
            $user_tmp = $this->show($id);
            $user = User::find($id);
            $user->delete();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return $user_tmp;
    }

    public static function hasEmail($email, $id = 0){
        return self::whereEmail($email)->where('id','<>',$id)->first();
    }
}
