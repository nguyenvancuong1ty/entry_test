<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
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
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'hotel_id' => ['required', 'integer', 'exists:hotels,hotel_id'],
            'hotel_name' => ['required', 'string', 'max:255'],
            'prefecture_id' => ['required', 'integer', 'exists:prefectures,prefecture_id'],
            'new_file_path' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'hotel_id.required' => 'ホテルIDが不正です。',
            'hotel_id.exists' => '指定されたホテルが見つかりません。',
            'hotel_name.required' => 'ホテル名を入力してください。',
            'hotel_name.max' => 'ホテル名は255文字以内で入力してください。',
            'prefecture_id.required' => '都道府県を選択してください。',
            'prefecture_id.exists' => '有効な都道府県を選択してください。',
        ];
    }
}
