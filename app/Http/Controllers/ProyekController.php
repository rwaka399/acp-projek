<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Proyek;
use App\Services\ProyekService;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProyekService::dataAll();

        return view('proyek.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proyek.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = [
            'proyek_name' => $request->input('proyek_name'),
            'proyek_description' => $request->input('proyek_description'),
        ];

        $validate = Validator::make($payload, [
            'proyek_name' => 'required|string',
            'proyek_description' => 'required',
        ], [
            'required' => ':attribute harus diisi',
            'string' => ':attribute harus berupa string',
        ], [
            'proyek_name' => 'Nama Proyek',
            'proyek_description' => 'Deskripsi Proyek',
        ]);

        if ($validate->fails()) {
            return ResponseFormatter::error([
                'error' => $validate->errors()->all(),
            ], 'validation failed', 402);
        }

        $data = ProyekService::create($payload);
        if (!$data['status']) {
            return ResponseFormatter::error($data['errors'], 'create data unsuccessful');
        }


        return redirect()->route('proyek.all');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ProyekService::getById($id);
        if(!$data['status']) {
            $errorCode = $data['errors'] == 'Not Found' ? 404 : 400;
            return ResponseFormatter::error([
                'errors' => $data['errors'],
            ], 'get data unsuccessful', $errorCode);
        }

        return view('proyek.show', ['data' => $data['data']]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payload = [
            'proyek_name' => $request->input('proyek_name'),
            'proyek_description' => $request->input('proyek_description'),
        ];

        $validate = Validator::make($payload, [
            'proyek_name' => 'required|string',
            'proyek_description' => 'required',
        ], [
            'required' => ':attribute harus diisi',
            'string' => ':attribute harus berupa string',
        ], [
            'proyek_name' => 'Nama Proyek',
            'proyek_description' => 'Deskripsi Proyek',
        ]);

        if ($validate->fails()) {
            return ResponseFormatter::error([
                'error' => $validate->errors()->all(),
            ], 'validation failed', 402);
        }

        $data = ProyekService::update($payload, $id);
        if (!$data['status']) {
            return ResponseFormatter::error($data['errors'], 'update data unsuccessful');
        }

        return redirect()->route('proyek.all');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProyekService::delete($id);
        if(!$data['status']) {
            return ResponseFormatter::error($data['errors'], 'delete data unsuccessful');
        }

        return redirect()->route('proyek.all');
    }

}
