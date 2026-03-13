<?php

namespace App\Http\Requests;

use App\Models\Paslon;
use App\Models\Pemilih;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreVoteRequest extends FormRequest
{
    private ?Pemilih $resolvedPemilih = null;
    private ?Paslon $resolvedPaslon = null;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paslon_id' => ['required', 'integer', 'exists:paslon,id'],
            'jenis_vote' => [
                'required',
                'string',
                Rule::in(array_keys(config('pemira.vote_types', []))),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'paslon_id.required' => 'Paslon wajib dipilih.',
            'paslon_id.integer' => 'Paslon tidak valid.',
            'paslon_id.exists' => 'Paslon tidak ditemukan.',
            'jenis_vote.required' => 'Jenis vote wajib diisi.',
            'jenis_vote.in' => 'Jenis vote tidak valid.',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $pemilih = $this->pemilih();

                if (!$pemilih) {
                    $validator->errors()->add('auth', 'Sesi pemilih tidak valid. Silakan login ulang.');
                    return;
                }

                $paslon = $this->paslon();
                $jenisVote = (string) $this->input('jenis_vote');

                if ($paslon && $paslon->jenis_pemilihan !== $jenisVote) {
                    $validator->errors()->add('paslon_id', 'Paslon tidak sesuai dengan jenis vote.');
                }

                $allowedVotes = array_filter(
                    array_map('trim', explode(',', (string) $pemilih->jenis_pemilihan))
                );

                if ($jenisVote !== '' && !in_array($jenisVote, $allowedVotes, true)) {
                    $validator->errors()->add('jenis_vote', 'Anda tidak memiliki hak suara untuk jenis ini.');
                }
            },
        ];
    }

    public function pemilih(): ?Pemilih
    {
        if ($this->resolvedPemilih) {
            return $this->resolvedPemilih;
        }

        $npm = $this->session()->get('npm');
        if (!$npm) {
            return null;
        }

        $this->resolvedPemilih = Pemilih::where('npm', $npm)->first();

        return $this->resolvedPemilih;
    }

    public function paslon(): ?Paslon
    {
        if ($this->resolvedPaslon) {
            return $this->resolvedPaslon;
        }

        $paslonId = $this->input('paslon_id');
        if (!$paslonId) {
            return null;
        }

        $this->resolvedPaslon = Paslon::find($paslonId);

        return $this->resolvedPaslon;
    }

    protected function failedValidation(ValidatorContract $validator): void
    {
        $message = $validator->errors()->first() ?: 'Data vote tidak valid.';

        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->with('error', $message)
        );
    }
}
