<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ServiceAccordion extends Component
{
    public $rows = [];

    protected $rules = [
        'rows.*.title' => 'required|string',
        'rows.*.body' => 'required|string',
    ];

    public function mount($service = null, $errors = null)
    {
        if ($service) {
            $this->rows = old('rows', $service->toArray());
        }else {
            $this->rows = old('rows', []);
        }
    }

    public function addRow()
    {
        $this->rows[] = ['title' => '', 'body' => ''];
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }

    public function submit()
    {
        $this->validate();

        // Code to handle form submission
    }

    public function render()
    {
        return view('livewire.service-accordion');
    }

}
