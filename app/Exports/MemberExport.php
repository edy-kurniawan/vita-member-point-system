<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $member = Member::with([
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan'
        ])->get();

        foreach ($member as $key => $value) {
            $data[] = [
                'No'            => $key + 1,
                'Nama'          => $value->nama,
                'Jenis Kelamin' => $value->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                'Tanggal Lahir' => date('d-m-Y', strtotime($value->tanggal_lahir)),
                'No HP'         => $value->no_hp,
                'Provinsi'      => $value->provinsi->name,
                'Kabupaten'     => $value->kabupaten->name,
                'Kecamatan'     => $value->kecamatan->name,
                'Kelurahan'     => $value->kelurahan->name,
                'Alamat'        => $value->alamat,
                'Tanggal Registrasi' => date('d-m-Y', strtotime($value->tanggal_registrasi)),
                'Tanggal Expired'    => date('d-m-Y', strtotime($value->tanggal_expired)),
                'Keterangan' => $value->keterangan,
                'Total Point' => $value->total_point ?? 0
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'No HP',
            'Provinsi',
            'Kabupaten',
            'Kecamatan',
            'Kelurahan',
            'Alamat',
            'Tanggal Registrasi',
            'Tanggal Expired',
            'Keterangan',
            'Total Point'
        ];
    }
}
