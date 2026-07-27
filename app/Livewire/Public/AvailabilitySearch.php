<?php

namespace App\Livewire\Public;

use Livewire\Component;

class AvailabilitySearch extends Component
{
    public ?string $checkIn = null;

    public ?string $checkOut = null;

    public int $adults = 2;

    public int $children = 0;

    public int $pets = 0;

    public function mount(): void
    {
        $query = request()->query();

        $this->checkIn = $query['check_in'] ?? $this->checkIn;
        $this->checkOut = $query['check_out'] ?? $this->checkOut;
        $this->adults = isset($query['adults']) ? (int) $query['adults'] : $this->adults;
        $this->children = isset($query['children']) ? (int) $query['children'] : $this->children;
        $this->pets = isset($query['pets']) ? (int) $query['pets'] : $this->pets;
    }

    public function search()
    {
        $this->validate([
            'checkIn' => ['required', 'date', 'after_or_equal:today'],
            'checkOut' => ['required', 'date', 'after:checkIn'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['required', 'integer', 'min:0'],
            'pets' => ['required', 'integer', 'min:0'],
        ]);

        return $this->redirect(route('houses.index', [
            'locale' => app()->getLocale(),
            'check_in' => $this->checkIn,
            'check_out' => $this->checkOut,
            'adults' => $this->adults,
            'children' => $this->children,
            'pets' => $this->pets,
        ]));
    }

    public function render()
    {
        return view('livewire.public.availability-search');
    }
}
