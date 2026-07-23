<?php

namespace App\Services;

class PriceBreakdown
{
    public function __construct(
        public readonly int $nights,
        public readonly float $accommodationSubtotal,
        public readonly array $extraCosts,
        public readonly float $extraCostsTotal,
        public readonly ?array $discount,
        public readonly float $discountAmount,
        public readonly float $total,
    ) {}

    public function toArray(): array
    {
        return [
            'nights' => $this->nights,
            'accommodation_subtotal' => $this->accommodationSubtotal,
            'extra_costs' => $this->extraCosts,
            'extra_costs_total' => $this->extraCostsTotal,
            'discount' => $this->discount,
            'discount_amount' => $this->discountAmount,
            'total' => $this->total,
        ];
    }
}
