<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class DataClient implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'client_name'    => $row[1],
            'client_phone'    => $row[2],
            'client_address'    => $row[3],
            // 'password' => Hash::make($row[2]),
        ]);
    }
}
