<?php

namespace App\Services\Satusehat;

use Illuminate\Support\Facades\Http;

class SatusehatService
{
    public function __construct(private SatusehatAuthService $authService)
    {
    }

    private function baseUrl(): string
    {
        $environment =
            setting('satusehat_environment');

        return $environment === 'production'
            ? 'https://api-satusehat.kemkes.go.id/fhir-r4'
            : 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4';
    }

    public function get(string $endpoint,array $query = [])
    {
        return Http::withToken(
                $this->authService->getAccessToken()
            )
            ->acceptJson()
            ->get(
                $this->baseUrl() . $endpoint,
                $query
            );
    }

    public function post(string $endpoint,array $payload = [])
    {
        return Http::withToken(
                $this->authService->getAccessToken()
            )
            ->acceptJson()
            ->post(
                $this->baseUrl() . $endpoint,
                $payload
            );
    }

    public function put(string $endpoint,array $payload = [])
    {
        return Http::withToken(
                $this->authService->getAccessToken()
            )
            ->acceptJson()
            ->put(
                $this->baseUrl() . $endpoint,
                $payload
            );
    }
}