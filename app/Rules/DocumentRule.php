<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DocumentRule implements Rule
{
    protected $regex;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $regex)
    {
        $this->regex = $regex;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (! ($value instanceof UploadedFile) || ! $value->isValid()) {
            return false;
        }
        return preg_match($this->regex, $value->getClientOriginalName()) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //return 'File document pabean salah';
        return "Format nama dokumen pabean salah";
    }
}
