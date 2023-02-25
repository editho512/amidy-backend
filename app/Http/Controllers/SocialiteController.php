<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Socialite; // <-- ne pas oublier

class SocialiteController extends Controller
{
    // Les tableaux des providers autorisés
    protected $providers = ["google", "github", "facebook"];

    # La vue pour les liens vers les providers
    public function loginRegister()
    {
        return view("socialite.login-register");
    }

    # redirection vers le provider
    public function redirect(Request $request)
    {

        $provider = $request->provider;


        // On vérifie si le provider est autorisé
        if (in_array($provider, $this->providers)) {
            return Socialite::driver($provider)->redirect(); // On redirige vers le provider
        }
        abort(404); // Si le provider n'est pas autorisé
    }

    // Callback du provider
    public function callback(Request $request)
    {
        $provider = $request->provider;

        if (in_array($provider, $this->providers)) {

            // Les informations provenant du provider
            $data = Socialite::driver($request->provider)->user();
            // Les informations de l'utilisateur
            $users = $data->user;
            $user = User::where("email", $users["email"])->first();

            // voir les informations de l'utilisateur
            if (!$user) {

               $user = User::create([
                    'name' => $users["name"],
                    'email' => $users["email"],
                    'password' => Hash::make("Azerty512@")
                ]);

            }

            //Auth::attempt(["email" => $user["email"], "password" => "Azerty512"]);

            return ["token" => $user->createToken('authToken')->plainTextToken];

        }
        abort(404);
    }
}
