<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SearchHotelRequest extends FormRequest
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
            'hotel_name' => ['nullable', 'string', 'max:255'],
            'prefecture_id' => ['nullable', 'integer', 'exists:prefectures,prefecture_id'],
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
            'hotel_name.max' => 'ホテル名は255文字以内で入力してください。',
            'prefecture_id.exists' => '有効な都道府県を選択してください。',
        ];
    }

    /**
     * Check if no search filter was provided
     */
    public function isEmptySearch(): bool
    {
        $name = $this->input('hotel_name');
        $pref = $this->input('prefecture_id');

        return ($name === null || trim((string) $name) === '') && empty($pref);
    }

    /**
     * Get sanitized hotel name query
     */
    public function getHotelName(): ?string
    {
        $name = $this->input('hotel_name');
        return ($name !== null && trim((string) $name) !== '') ? trim((string) $name) : null;
    }

    /**
     * Get sanitized prefecture id
     */
    public function getPrefectureId(): ?int
    {
        return $this->filled('prefecture_id') ? $this->integer('prefecture_id') : null;
    }
}
