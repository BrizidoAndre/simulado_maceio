<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Model::automaticallyEagerLoadRelationships();
        JsonResource::withoutWrapping();
        \Auth::viaRequest('api-driver', function (Request $request) {
            $token = $request->bearerToken();
            $user = User::where('token', $token)->first();
            if (!$user) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Unauthenticated',
                ], 401));
            }
            return $user;
        });
        //
    }
}
