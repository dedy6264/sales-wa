<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataClient;


class ClientController extends Controller
{
    public function index()
    {
        return view('contents.client.index');
    }
    public function all(Request $request){
        abort_if(!$request->header('X-XSRF-TOKEN'), 404);
        return Client::get();
    }
    public function store(ClientRequest $request)
    {
        dump($request->all());
        Client::create($request->validated());
        return true;
    }  
    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        return true;
    }
    public function destroy(Client $client)
    {
        $client->delete();
        return true;
    }
    public function import(Request $request)
    {
        dd($request->all());
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/',$nama_file);

        // import data
        $import = Excel::import(new DataClient(), storage_path('app/public/excel/'.$nama_file));

        //remove from server
        Storage::delete($path);

        if($import) {
            //redirect
            return redirect()->route('client.all')->with(['success' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('client.all')->with(['error' => 'Data Gagal Diimport!']);
        }
    }

}
