<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SearchBookingRequest extends FormRequest
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
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_contact' => ['nullable', 'string', 'max:255'],
            'chekin_time' => ['nullable', 'date'],
            'checkout_time' => ['nullable', 'date'],
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
            'customer_name.max' => '顧客名は255文字以内で入力してください。',
            'customer_contact.max' => '顧客連絡先は255文字以内で入力してください。',
            'chekin_time.date' => '有効なチェックイン日時を入力してください。',
            'checkout_time.date' => '有効なチェックアウト日時を入力してください。',
            'per_page.in' => "表示件数は{$optionsText}のいずれかを指定してください。",
        ];
    }

    /**
     * Extract sanitized search filters
     *
     * @return array{customer_name: ?string, customer_contact: ?string, chekin_time: ?string, checkout_time: ?string}
     */
    public function toFilters(): array
    {
        $name = $this->input('customer_name');
        $contact = $this->input('customer_contact');
        $checkin = $this->input('chekin_time');
        $checkout = $this->input('checkout_time');

        return [
            'customer_name' => ($name !== null && trim((string) $name) !== '') ? trim((string) $name) : null,
            'customer_contact' => ($contact !== null && trim((string) $contact) !== '') ? trim((string) $contact) : null,
            'chekin_time' => ($checkin !== null && trim((string) $checkin) !== '') ? trim((string) $checkin) : null,
            'checkout_time' => ($checkout !== null && trim((string) $checkout) !== '') ? trim((string) $checkout) : null,
        ];
    }

    /**
     * Check if all search fields are empty
     */
    public function isEmptySearch(): bool
    {
        $filters = $this->toFilters();
        return empty($filters['customer_name'])
            && empty($filters['customer_contact'])
            && empty($filters['chekin_time'])
            && empty($filters['checkout_time']);
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
