<?php

namespace App\DTO;

use Mithridatem\Validation\Attributes\Email;
use Mithridatem\Validation\Attributes\NotBlank;
use Mithridatem\Validation\Attributes\Pattern;

class UserLoginDTO extends DTO
{
    #[NotBlank]
    #[Email]
    public string $email;
    #[NotBlank]
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}