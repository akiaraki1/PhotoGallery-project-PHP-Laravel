<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'avatar_image' => [
                'nullable',
                File::image()
                    ->max(5 * 1024), // 5 МБ
                'mimes:jpeg,jpg,png,webp,gif',   //  разрешенные расширения]
                Rule::dimensions()
                    ->maxWidth(500)
                    ->maxHeight(500)
            ],
        ];
    }
}
