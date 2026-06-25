<?php

namespace App\Services\Satusehat;

use App\Models\SatusehatToken;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class SatusehatAuthService
{
    public function getAccessToken(): string
    {
        $token = SatusehatToken::query()
            ->latest()
            ->first();

        if (
            $token &&
            $token->expires_at->isFuture()
        ) {
            return $token->access_token;
        }

        return $this->generateToken();
    }

    private function generateToken(): string
    {
        if (
            empty($settings['satusehat_client_key']) ||
            empty($settings['satusehat_client_secret'])
        ) {
            throw new \RuntimeException(
                'SATUSEHAT credentials are not configured.'
            );
        }

        $settings = Setting::pluck(
            'value',
            'key'
        );

        $baseUrl =
            ($settings['satusehat_environment'] ?? 'sandbox')
            === 'production'
                ? 'https://api-satusehat.kemkes.go.id'
                : 'https://api-satusehat-stg.dto.kemkes.go.id';

        $response = Http::asForm()
            ->post(
                $baseUrl . '/oauth2/v1/accesstoken?grant_type=client_credentials',
                [
                    'client_id' =>
                        $settings['satusehat_client_key'] ?? '',

                    'client_secret' =>
                        $settings['satusehat_client_secret'] ?? '',
                ]
            );

        $response->throw();

        $data = $response->json();

        SatusehatToken::query()->delete();

        SatusehatToken::create([
            'access_token' =>
                $data['access_token'],

            'expires_at' =>
                Carbon::now()->addSeconds(
                    $data['expires_in'] - 60
                ),
        ]);

        return $data['access_token'];
    }
}