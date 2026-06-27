<?php

namespace App\Services\Satusehat;

class SatusehatOrganizationService
{
    public function __construct(
        protected SatusehatService $satusehat
    ) {
    }

    public function get()
    {
        return $this->satusehat->get(
            '/Organization/' . setting('satusehat_organization_id')
        )->throw()->json();
    }
}