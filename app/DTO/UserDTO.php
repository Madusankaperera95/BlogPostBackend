<?php

namespace App\DTO;

use Illuminate\Http\UploadedFile;

class UserDTO
{

    public string $name;
    public string $email;
    public string $password;
    public UploadedFile|null $image;

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param UploadedFile $image
     */
    public function __construct(string $name, string $email, string $password, UploadedFile $image)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->image = $image;
    }


}
