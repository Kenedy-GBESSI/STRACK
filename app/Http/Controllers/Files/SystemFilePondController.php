<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Data\File\FileResponseHeadersData;
use App\Models\Candidacy;
use App\Models\InternShip;
use App\Models\Offer;
use App\Services\Files\FileMimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class SystemFilePondController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $file = InternShip::where('file_associated_name', $request->restore)->first();
        $disk = InternShip::relatedFileDisk();
        $path = $file?->file_associated_path;

        if (! $file) {
            $file = Offer::where('file_associated_name', $request->restore)->first();
            $disk = Offer::relatedFileDisk();
            $path = $file?->file_associated_path;
        }

        if (! $file) {
            $file = Candidacy::where('file_associated_name', $request->restore)->first();
            $disk = Candidacy::relatedFileDisk();
            $path = $file?->file_associated_path;
        }

        $responseHeaders = FileMimeService::getResponseHeaders($file);

        if (empty($path) || ! ($responseHeaders instanceof FileResponseHeadersData)) {
            return response('File not found!', 404);
        }

        $contents = Storage::disk($disk)->get($path);

        return response($contents, 200, $responseHeaders->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        return Response::make('', 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
