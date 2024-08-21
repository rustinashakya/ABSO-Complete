<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportContacts implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Phone',
            'Subject',
            'Message',
            'Address',
        ];
    }

    public function collection()
    {
        return Contact::select('id','name','email','phone_no','subject','message','address')->get();
    }
}
