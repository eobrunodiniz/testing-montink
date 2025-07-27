<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Services\CouponService;
use App\Models\Coupon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CouponController extends Controller
{
    /**
     * Injeta o serviço de cupons.
     *
     * @param CouponService $service Serviço responsável pela lógica de cupons.
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function __construct(private CouponService $service) {}

    /**
     * Exibe a lista de cupons cadastrados.
     *
     * @return View
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function index(): View
    {
        $coupons = $this->service->list();
        return view('coupons.index', compact('coupons'));
    }

    /**
     * Exibe o formulário de criação de cupom.
     *
     * @return View
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function create(): View
    {
        $coupon = new Coupon();
        return view('coupons.create', compact('coupon'));
    }

    /**
     * Salva um novo cupom no banco de dados.
     *
     * @param CouponRequest $request Dados validados do cupom.
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function store(CouponRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());
        return to_route('coupons.index')
            ->with('success', 'Cupom criado com sucesso.');
    }

    /**
     * Exibe o formulário de edição de um cupom.
     *
     * @param int $id ID do cupom.
     * @return View
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function edit(int $id): View
    {
        $coupon = $this->service->find($id);
        return view('coupons.edit', compact('coupon'));
    }

    /**
     * Atualiza um cupom existente.
     *
     * @param CouponRequest $request Dados validados do cupom.
     * @param int $id ID do cupom.
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function update(CouponRequest $request, int $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());
        return to_route('coupons.index')
            ->with('success', 'Cupom atualizado com sucesso.');
    }

    /**
     * Remove um cupom do banco de dados.
     *
     * @param int $id ID do cupom.
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->service->destroy($id);
        return to_route('coupons.index')
            ->with('success', 'Cupom removido.');
    }
}
