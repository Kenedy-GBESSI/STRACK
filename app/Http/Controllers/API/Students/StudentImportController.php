<?php

namespace App\Http\Controllers\API\Students;

use App\Data\File\FileData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\StudentImportRequest;
use App\Imports\StudentImport;
use App\Services\Files\FileMimeService;

class StudentImportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(StudentImportRequest $request)
    {
        $filePath = (new FileMimeService)->getPath(FileData::from($request->importData));

        try {

            $import = new StudentImport();
            $import->import($filePath);

            return response()->json([
                'success' => true,
            ]);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                ];
            }

            return response()->json([
                'success' => false,
                'errors' => $errors,
            ]);
        }
    }
}
