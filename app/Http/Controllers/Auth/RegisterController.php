<?php

namespace App\Http\Controllers\Auth;

use App\Professor;
use App\Palavra;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Storage;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/inicio-professor';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'usuario' => 'required|string|max:50',
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:professores',
            'senha' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Professor
     */
    protected function create(array $data)
    {
        $professor = Professor::create([
            'usuario' => $data['usuario'],
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => Hash::make($data['senha']),
        ]);

        $arquivo = base_path() . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'palavras.dat';

        try {
            $handle = fopen($arquivo, "r");

            while(($sql = fgets($handle)) !== false)
                DB::unprepared(DB::raw(str_replace('?', $professor->id, $sql)));
        } finally {
            if(isset($handle))
                fclose($handle);
        }

        return $professor;
    }
}
