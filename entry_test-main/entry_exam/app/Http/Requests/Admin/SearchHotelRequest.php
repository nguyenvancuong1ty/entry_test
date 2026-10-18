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
        $options = implode(',', config('pagination.options', [10, 20, 30, 50, 100]));

        return [
            'hotel_name' => ['nullable', 'string', 'max:255'],
            'prefecture_id' => ['nullable', 'integer', 'exists:prefectures,prefecture_id'],
            'per_page' => ['nullable', 'integer', "in:{$options}"],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $optionsText = implode(', ', config('pagination.options', [10, 20, 30, 50, 100]));

        return [
            'hotel_name.max' => 'ホテル名は255文字以内で入力してください。',
            'prefecture_id.exists' => '有効な都道府県を選択してください。',
            'per_page.in' => "表示件数は{$optionsText}のいずれかを指定してください。",
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

    /**
     * Get validated per_page count (default: from config)
     */
    public function getPerPage(): int
    {
        $allowed = config('pagination.options', [10, 20, 30, 50, 100]);
        $default = (int) config('pagination.default_per_page', 10);
        $val = $this->integer('per_page');

        return in_array($val, $allowed, true) ? $val : $default;
    }
}
