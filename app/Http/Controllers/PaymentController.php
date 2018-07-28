<?php
namespace App\Http\Controllers;

use App\Http\Requests\Payment\StorePaymentSettingsRequest;
use App\Models\PaymentSetting;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class PaymentController extends Controller
{
    public function storeSettings(StorePaymentSettingsRequest $request, AuthService $authService)
    {
        $user = Request::user();
        if (!$user->paymentSettings) {
            $paymentSettings = new PaymentSetting([
                'card_number' => $request->card_number,
                'expiry_date' => $request->exp_date,
                'cvv' => $request->cvv,
                'verified' => 1,
            ]);
            $paymentSettings->save();
            $user->update(['payment_settings_id' => $paymentSettings->id]);
        } else {
            $user->paymentSettings->update([
                'card_number' => $request->card_number,
                'expiry_date' => $request->exp_date,
                'cvv' => $request->cvv,
                'verified' => 1,
            ]);
        }
        $token = $authService->authenticateById($user);
        return $this->respondWithData(['token' => $token ,'authUser' =>  ['data' =>new UserResource($user)]]);
    }
}