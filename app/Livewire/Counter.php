<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public function render()
    {
        return view('livewire.counter');
    }


    public function inc(): void
    {
        $this->count++;
    }

    public function dec(): void
    {
        $this->count--;
    }

}
