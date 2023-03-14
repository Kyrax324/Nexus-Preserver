<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Log;
class Recaptcha implements Rule
{
    const URL = 'https://www.google.com/recaptcha/api/siteverify';

    public $errors = ['ReCaptcha error detected'];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $response = Http::post((static::URL)."?".http_build_query([
            'secret' => config('services.recaptcha.secret'),
            'response' => $value,
            'remoteip' => request()->ip()
        ]))->json();

        if ($response['success'] == false)
		{
			$this->errors = array_merge($this->errors, $response['error-codes']);
			return false;
		}

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errors;
    }
}
