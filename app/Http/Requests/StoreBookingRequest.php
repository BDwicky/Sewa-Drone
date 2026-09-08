<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Validator;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'renter_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:25'],
            'email' => ['nullable', 'email'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'with_pilot' => ['nullable', 'boolean'],
            'delivery' => ['nullable', 'boolean'],
            'voucher_code' => ['nullable', 'string', 'max:30'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            // Turnstile anti-bot (no-op bila secret belum diisi)
            $secret = config('services.turnstile.secret');
            if ($secret) {
                $resp = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => $secret,
                    'response' => $this->input('cf-turnstile-response'),
                    'remoteip' => $this->ip(),
                ]);
                if (! ($resp->json('success') ?? false)) {
                    $validator->errors()->add('cf-turnstile-response', 'Verifikasi manusia gagal. Silakan coba lagi.');
                }
            }

            if ($validator->errors()->any()) {
                return;
            }

            $start = Carbon::parse($this->input('start_date'));
            $end = Carbon::parse($this->input('end_date'));
            $drone = $this->route('drone');

            if ($drone && $drone->bookings()->overlapping($drone->id, $start, $end)->exists()) {
                $validator->errors()->add('start_date', 'Drone ini sudah dibooking pada rentang tanggal tersebut. Silakan pilih tanggal lain.');
            }
        });
    }
}
