<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductPrijsRequest;
use App\Models\Behandeling;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class BehandelingProductController extends Controller
{
    // Wireframe-03: producten die horen bij de gekozen behandeling.
    public function index(Behandeling $behandeling): View
    {
        $this->authorizeEigenaar();

        $producten = Product::getByBehandeling((int) $behandeling->Id);

        return view('behandelingen.producten.index', compact('behandeling', 'producten'));
    }

    // Wireframe-04: detail van een product binnen de gekozen behandeling.
    public function show(Behandeling $behandeling, int $product): View
    {
        $this->authorizeEigenaar();

        $productDetail = Product::getDetailByBehandeling((int) $behandeling->Id, $product);

        abort_if($productDetail === null, 404);

        return view('behandelingen.producten.show', compact('behandeling', 'productDetail'));
    }

    // Wireframe-05: wijzigformulier voor verkoopprijs.
    public function edit(Behandeling $behandeling, int $product): View
    {
        $this->authorizeEigenaar();

        $productDetail = Product::getDetailByBehandeling((int) $behandeling->Id, $product);

        abort_if($productDetail === null, 404);

        return view('behandelingen.producten.edit', compact('behandeling', 'productDetail'));
    }

    // Slaat alleen nieuwe verkoopprijs op met server-side 30%-controle.
    public function update(UpdateProductPrijsRequest $request, Behandeling $behandeling, int $product): RedirectResponse
    {
        $this->authorizeEigenaar();

        $productDetail = Product::getDetailByBehandeling((int) $behandeling->Id, $product);
        abort_if($productDetail === null, 404);

        try {
            Product::updateVerkoopPrijsViaProcedure($product, (float) $request->validated('nieuwe_verkoopprijs'));
        } catch (\Throwable $throwable) {
            Log::error('Wijzigen productprijs mislukt.', [
                'behandeling_id' => $behandeling->Id,
                'product_id' => $product,
                'user_id' => $request->user()?->id,
                'exception' => $throwable->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gegevens niet bijgewerkt');
        }

        return redirect()
            ->route('behandelingen.producten.show', ['behandeling' => $behandeling->Id, 'product' => $product])
            ->with('status_product', 'Productprijs bijgewerkt.');
    }

    private function authorizeEigenaar(): void
    {
        $user = auth()->user();

        if (! $user || $user->role !== 'eigenaar') {
            abort(403);
        }
    }
}
