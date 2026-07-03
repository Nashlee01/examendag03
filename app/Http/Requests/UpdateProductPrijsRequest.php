<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductPrijsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'eigenaar';
    }

    protected function prepareForValidation(): void
    {
        $prijs = (string) $this->input('nieuwe_verkoopprijs', '');
        $prijs = str_replace(',', '.', $prijs);

        $this->merge([
            'nieuwe_verkoopprijs' => $prijs,
        ]);
    }

    public function rules(): array
    {
        return [
            'nieuwe_verkoopprijs' => [
                'required',
                'numeric',
                'min:0',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $productId = (int) $this->route('product');
                    $inkoopPrijs = Product::getInkoopPrijs($productId);

                    if ($inkoopPrijs === null) {
                        $fail('Product niet gevonden.');

                        return;
                    }

                    if ((float) $value < ($inkoopPrijs * 1.30)) {
                        $fail('Verkoopprijs moet minimaal 30 procent boven de inkoopprijs liggen.');
                    }
                },
            ],
        ];
    }
}
