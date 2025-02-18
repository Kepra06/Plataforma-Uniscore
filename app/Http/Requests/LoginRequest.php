<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ];
    }

    /**
     * Get the credentials needed for login.
     */
    public function getCredentials(): array
{
    $username = $this->get('username');

    // Verifica si el nombre de usuario es un correo electrónico
    if ($this->isEmail($username)) {
        return [
            'email' => $username,
            'password' => $this->get('password')
        ];
    }

    // Si no es un correo, intenta con el nombre de usuario
    return $this->only('username', 'password');
}



    /**
     * Determine if the provided value is an email address.
     */
    public function isEmail($value): bool
    {
        $factory = $this->container->make(ValidationFactory::class);

        return !$factory->make(
            ['username' => $value],
            ['username' => 'email']
        )->fails();
    }
}
