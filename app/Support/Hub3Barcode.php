<?php

namespace App\Support;

use App\Models\Reservation;
use Com\Tecnick\Barcode\Barcode;

/**
 * Generates the Croatian "HUB3" PDF417 payment barcode ("Skeniraj i plati") read by
 * domestic mobile banking apps. Field order/lengths/encoding follow HUB's official
 * HRVHUB30 specification (v6, EUR-era): 14 UTF-8 fields joined by "\n", amount is the
 * only zero-padded field (15 digits, last 2 are cents).
 */
class Hub3Barcode
{
    private const FIELD_LENGTHS = [8, 3, 15, 30, 27, 27, 25, 25, 27, 21, 4, 22, 4, 35];

    private const FIELD_KEYS = [
        'header', 'currency', 'amount',
        'payerName', 'payerAddress1', 'payerAddress2',
        'payeeName', 'payeeAddress1', 'payeeAddress2', 'iban',
        'model', 'reference', 'purposeCode', 'description',
    ];

    public static function payload(array $fields): string
    {
        $lines = [];

        foreach (self::FIELD_KEYS as $i => $key) {
            $lines[] = mb_substr((string) ($fields[$key] ?? ''), 0, self::FIELD_LENGTHS[$i]);
        }

        return implode("\n", $lines)."\n";
    }

    public static function amountToField(float $amount): string
    {
        return str_pad((string) (int) round($amount * 100), 15, '0', STR_PAD_LEFT);
    }

    public static function png(string $payload): string
    {
        $barcode = new Barcode();

        // PDF417, default aspect ratio, error correction level 4 (per HUB3 spec).
        return $barcode->getBarcodeObj('PDF417,,4', $payload, -3, -3)->getPngData();
    }

    public static function forReservation(Reservation $reservation): string
    {
        $guest = $reservation->guest;
        $company = config('site.company');

        $payerCountry = $guest?->country
            ? (Countries::options('hr')[$guest->country] ?? '')
            : '';

        return self::payload([
            'header' => 'HRVHUB30',
            'currency' => 'EUR',
            'amount' => self::amountToField((float) $reservation->total_price),
            'payerName' => trim(($guest->first_name ?? '').' '.($guest->last_name ?? '')),
            'payerAddress1' => $guest->address ?? '',
            'payerAddress2' => $payerCountry,
            'payeeName' => $company['name'],
            'payeeAddress1' => $company['address'],
            'payeeAddress2' => $company['zip_city'],
            'iban' => str_replace(' ', '', $company['iban']),
            'model' => 'HR99',
            'reference' => '',
            'purposeCode' => '',
            'description' => 'Rezervacija #'.$reservation->id,
        ]);
    }
}
