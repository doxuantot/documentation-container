<?php

namespace App\Containers\Vendor\Documentation\UI\WEB\Requests;

use App\Containers\Vendor\Documentation\Traits\HasDocAccessTrait;
use App\Ship\Parents\Requests\Request as AbstractRequest;

class GetPrivateDocumentationRequest extends AbstractRequest
{
    use HasDocAccessTrait;

    protected array $decode = [];

    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return $this->hasDocAccess();
    }
}
