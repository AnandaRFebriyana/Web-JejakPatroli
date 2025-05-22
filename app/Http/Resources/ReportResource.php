<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        // Debug: Lihat nilai attachment sebelum diproses
        \Log::info('Raw attachment: ' . $this->attachment);

        // Pastikan attachment adalah string JSON yang valid
        if (is_string($this->attachment)) {
            try {
                $attachments = json_decode($this->attachment, true);
                // Jika hasil decode masih berupa string, coba decode lagi
                if (is_string($attachments)) {
                    $attachments = json_decode($attachments, true);
                }
            } catch (\Exception $e) {
                \Log::error('Error decoding attachment: ' . $e->getMessage());
                $attachments = [];
            }
        } else {
            $attachments = [];
        }

        // Jika attachments adalah array kosong atau null, gunakan array kosong
        if (empty($attachments)) {
            $attachments = [];
        }

        // Debug: Lihat hasil decode
        \Log::info('Decoded attachments: ', $attachments);

        $attachmentUrls = [];
        foreach ($attachments as $path) {
            // Bersihkan path dari karakter yang tidak diinginkan dan URL encoding
            $cleanPath = urldecode($path);
            $cleanPath = str_replace(['[', ']', '"'], '', $cleanPath);
            $cleanPath = str_replace('//', '/', $cleanPath);
            // Debug: Lihat path yang akan diproses
            \Log::info('Processing path: ' . $cleanPath);

            // Buat URL lengkap
            $url = asset('storage/' . $cleanPath);
            $attachmentUrls[] = $url;
        }

        // Debug: Lihat hasil akhir
        \Log::info('Final URLs: ', $attachmentUrls);

        return [
            'id' => $this->id,
            'guard_id' => $this->guard_id,
            'status' => $this->status,
            'description' => $this->description,
            'attachment' => $attachmentUrls,
            'created_at' => $this->created_at
        ];
    }
}
