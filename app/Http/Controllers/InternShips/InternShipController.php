<?php

namespace App\Http\Controllers\InternShips;

use App\Http\Controllers\Controller;
use App\Http\Requests\InternShips\StoreInternShipRequest;
use App\Http\Requests\InternShips\UpdateInternShipRequest;
use App\Models\InternShip;
use App\Traits\InteractsWithAlert;
use Illuminate\Http\Request;
use App\Data\File\FileData;
use App\Services\InternShips\InternShipService;
use Inertia\Inertia;

class InternShipController extends Controller
{
    use InteractsWithAlert;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('InternShips/Index', [
            'filters' => fn() => $request->all('search'),
            'internShips' => fn() => InternShip::query()
                ->filter(request()->only('search'))
                ->orderBy('start_date', 'asc')
                ->orderBy('end_date', 'asc')
                ->paginate(config('custom.records_per_page'))
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('InternShips/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreInternShipRequest $request, InternShipService $internShipService)
    {
        $internShip = InternShip::create($request->safe()->except('fileData'));

        $request->whenFilled('fileData', function (array $fileData) use ($internShip, $internShipService) {
            $internShipService->saveFile($internShip, FileData::from($fileData));
        });

        $this->alert('Le stage est planifié avec succès !');

        return to_route('intern-ships.edit', $internShip);
    }

    /**
     * Show the specified resource.
     *
     * @return \Inertia\Response
     */
    public function show(InternShip $internShip, InternShipService $internShipService)
    {
        return Inertia::render('InternShips/Show', [
            'internShip' => $internShipService->loadForDisplay($internShip),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Inertia\Response
     */
    public function edit(InternShip $internShip, InternShipService $internShipService)
    {
        return Inertia::render('InternShips/Edit', [
            'internShip' => $internShipService->loadForDisplay($internShip),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateInternShipRequest $request, InternShip $internShip, InternShipService $internShipService)
    {
        $internShip->update($request->safe()->except('fileData'));

        $request->whenFilled('fileData', function (array $fileData) use ($internShip, $internShipService) {
            $internShipService->saveFile($internShip, FileData::from($fileData));
        },  function () use ($internShip, $internShipService) {
            $internShipService->destroyFile($internShip);
        });

        $this->alert('Le stage est modifié avec succès !');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(InternShip $internShip)
    {
        $internShip->delete();

        $this->alert('Le stage est supprimé avec succès !');

        return back();
    }
}
