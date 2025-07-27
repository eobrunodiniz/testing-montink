<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Injeta o serviço de produtos.
     *
     * @param ProductService $service Serviço responsável pela lógica de produtos.
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function __construct(private ProductService $service) {}

    /**
     * Exibe a lista de produtos cadastrados.
     *
     * @return View
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function index(): View
    {
        $products = $this->service->list();
        return view('products.index', compact('products'));
    }

    /**
     * Exibe o formulário de criação de produto.
     *
     * @return View
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function create(): View
    {
        $product = new Product();
        return view('products.create', compact('product'));
    }

    /**
     * Salva um novo produto no banco de dados.
     *
     * @param ProductRequest $request Dados validados do produto.
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $this->service->store(
            $request->only(['name', 'price']),
            $request->input('variations'),
            $request->input('quantities')
        );

        return to_route('products.index')
            ->with('success', 'Produto criado com sucesso.');
    }

    /**
     * Exibe o formulário de edição de um produto.
     *
     * @param int $id ID do produto.
     * @return View
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function edit(int $id): View
    {
        $product = $this->service->find($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Atualiza um produto existente.
     *
     * @param ProductRequest $request Dados validados do produto.
     * @param int $id ID do produto.
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function update(ProductRequest $request, int $id): RedirectResponse
    {
        $this->service->update(
            $id,
            $request->only(['name', 'price']),
            $request->input('variations'),
            $request->input('quantities')
        );

        return to_route('products.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove um produto do banco de dados.
     *
     * @param int $id ID do produto.
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->service->destroy($id);
        return to_route('products.index')
            ->with('success', 'Produto removido.');
    }
}
