<?php

namespace App\Http\Controllers\Offers;

use App\Http\Controllers\Controller;
use App\Models\InternShip;
use App\Traits\InteractsWithAlert;
use Illuminate\Http\Request;
use App\Data\File\FileData;
use App\Http\Requests\Offers\StoreOfferRequest;
use App\Http\Requests\Offers\UpdateOfferRequest;
use App\Models\Offer;
use App\Services\Offers\OfferService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OfferController extends Controller
{
    use InteractsWithAlert;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Offers/Index', [
            'filters' => fn() => $request->all('search'),
            'offers' => fn() => Offer::query()
                ->where('company_id', Auth::user()->profile_id)
                ->with('internShip', 'company')
                ->filter(request()->only('search'))
                ->orderBy('title', 'asc')
                ->paginate(config('custom.records_per_page'))
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        return Inertia::render('Offers/Create', [
            'internShips' => InternShip::toMultiselectFormat(),
            'internShipId' => $request->has('from_intern_ship_id') ? $request->from_intern_ship_id : null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreOfferRequest $request, OfferService $offerService)
    {
        $offer = Offer::create($request->safe()->except('fileData'));

        $request->whenFilled('fileData', function (array $fileData) use ($offer, $offerService) {
            $offerService->saveFile($offer, FileData::from($fileData));
        });

        $this->alert('L\' offre est créé avec succès !');

        return to_route('offers.edit', $offer);
    }

    /**
     * Show the specified resource.
     *
     * @return \Inertia\Response
     */
    public function show(Offer $offer, OfferService $offerService)
    {
        return Inertia::render('Offers/Show', [
            'offer' => $offerService->loadForDisplay($offer),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Inertia\Response
     */
    public function edit(Offer $offer, OfferService $offerService)
    {
        return Inertia::render('Offers/Edit', [
            'offer' => $offerService->loadForDisplay($offer),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateOfferRequest $request, Offer $offer, OfferService $offerService)
    {
        $offer->update($request->safe()->except('fileData'));

        $request->whenFilled('fileData', function (array $fileData) use ($offer, $offerService) {
            $offerService->saveFile($offer, FileData::from($fileData));
        },  function () use ($offer, $offerService) {
            $offerService->destroyFile($offer);
        });

        $this->alert('L\'offre est modifiée avec succès !');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        $this->alert('L\'offre est supprimée avec succès !');

        return back();
    }
}
