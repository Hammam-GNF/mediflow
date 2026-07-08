<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdjustStockRequest;
use App\Http\Requests\Admin\StoreMedicationRequest;
use App\Http\Requests\Admin\UpdateMedicationRequest;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MedicationController extends Controller
{
    private function generateMedicationCode(): string
    {
        $last = Medication::query()
            ->latest('id')
            ->first();

        $next = $last
            ? $last->id + 1
            : 1;

        return 'MED' . str_pad(
            $next,
            6,
            '0',
            STR_PAD_LEFT
        );
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            return DataTables::of(
                Medication::query()->with('stock')
            )

                ->addIndexColumn()

                ->addColumn(
                    'stock',
                    fn ($medication) =>
                        $medication->stock?->current_stock ?? 0
                )

                ->editColumn('price', function ($medication) {

                    return 'Rp ' . number_format(
                        $medication->price,
                        0,
                        ',',
                        '.'
                    );

                })

                ->addColumn('status', function ($medication) {

                    return $medication->is_active

                        ? '
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Active
                            </span>
                        '

                        : '
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Inactive
                            </span>
                        ';

                })

                ->addColumn('action', function ($medication) {

                    $toggleText = $medication->is_active
                        ? 'Deactivate'
                        : 'Activate';

                    $toggleClass = $medication->is_active

                        ? '
                            bg-red-50
                            text-red-700
                            hover:bg-red-100
                        '

                        : '
                            bg-emerald-50
                            text-emerald-700
                            hover:bg-emerald-100
                        ';

                    return '

                        <div class="flex items-center gap-2 whitespace-nowrap">

                            <a
                                href="'.route(
                                    'admin.medications.adjust-stock',
                                    $medication
                                ).'"

                                class="
                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-sky-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-sky-700

                                    transition

                                    hover:bg-sky-100
                                "
                            >
                                Stock
                            </a>

                            <a
                                href="'.route(
                                    'admin.medications.stock-history',
                                    $medication
                                ).'"

                                class="
                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-slate-100
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-slate-700

                                    transition

                                    hover:bg-slate-200
                                "
                            >
                                History
                            </a>

                            <a
                                href="'.route(
                                    'admin.medications.edit',
                                    $medication
                                ).'"

                                class="
                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-blue-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-blue-700

                                    transition

                                    hover:bg-blue-100
                                "
                            >
                                Edit
                            </a>

                            <button
                                type="button"

                                data-url="'.route(
                                    'admin.medications.destroy',
                                    $medication
                                ).'"

                                class="
                                    toggle-medication-btn

                                    inline-flex
                                    items-center

                                    rounded-lg

                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold

                                    transition

                                    '.$toggleClass.'
                                "
                            >
                                '.$toggleText.'
                            </button>

                        </div>

                    ';
                })

                ->rawColumns([
                    'status',
                    'action',
                ])

                ->make(true);
        }

        return view('admin.medications.index');
    }

    public function create()
    {
        return view('admin.medications.create');
    }

    public function store(StoreMedicationRequest $request)
    {
        $medication = Medication::create([
            ...$request->safe()->except(
                'current_stock'
            ),

            'code' =>
                $this->generateMedicationCode(),

            'is_active' =>
                $request->boolean(
                    'is_active'
                ),
        ]);

        $medication->stock()->create([
            'current_stock' =>
                $request->current_stock,
        ]);

        $medication->stockMovements()->create([
            'type' => 'in',
            'quantity' => $request->current_stock,
            'notes' => 'Initial stock',
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.medications.index')
            ->with(
                'success',
                'Medication created successfully.'
            );
    }

    public function edit(Medication $medication)
    {
        $medication->load('stock');

        return view(
            'admin.medications.edit',
            compact('medication')
        );
    }

    public function update(UpdateMedicationRequest $request,Medication $medication)
    {

        $medication->update([
            ...$request->validated(),

            'is_active' =>
                $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.medications.index')
            ->with(
                'success',
                'Medication updated successfully.'
            );
    }

    public function adjustStock(Medication $medication)
    {
        $medication->load('stock');

        return view(
            'admin.medications.adjust-stock',
            compact('medication')
        );
    }

    public function storeAdjustment(AdjustStockRequest $request,Medication $medication)
    {
        $stock =
            $medication->stock;

        $quantity =
            $request->quantity;

        if (
            $request->type === 'out'
            &&
            $stock->current_stock < $quantity
        ) {

            return back()
                ->withErrors([
                    'quantity' =>
                        'Insufficient stock.'
                ]);
        }

        if (
            $request->type === 'in'
        ) {

            $stock->increment(
                'current_stock',
                $quantity
            );

        } else {

            $stock->decrement(
                'current_stock',
                $quantity
            );
        }

        $medication->stockMovements()
            ->create([

                'type' =>
                    $request->type,

                'quantity' =>
                    $quantity,

                'notes' =>
                    $request->notes,

                'user_id' =>
                    Auth::id(),
            ]);

        return redirect()
            ->route(
                'admin.medications.index'
            )
            ->with(
                'success',
                'Stock adjusted successfully.'
            );
    }

    public function stockHistory(Medication $medication)
    {
        $movements =
            $medication
                ->stockMovements()
                ->with('user')
                ->latest()
                ->paginate(20);

        return view(
            'admin.medications.stock-history',
            compact(
                'medication',
                'movements'
            )
        );
    }

    public function destroy(Medication $medication)
    {
        $newStatus = ! $medication->is_active;

        $medication->update([
            'is_active' => $newStatus,
        ]);

        return back()->with(
            'success',
            $newStatus
                ? 'Medication activated successfully.'
                : 'Medication deactivated successfully.'
        );
    }
}
