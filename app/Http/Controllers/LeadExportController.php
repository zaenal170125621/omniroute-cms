<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadExportController extends Controller
{
    public function __invoke(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename=prospek-' . now()->format('Y-m-d_His') . '.csv',
        ];

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');

            // BOM agar Excel membaca UTF-8 dengan benar.
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Nama', 'Email', 'Telepon', 'Perusahaan', 'Layanan', 'Paket',
                'Budget', 'Timeline', 'Status', 'Sumber', 'Tanggal',
            ]);

            Lead::with('service')->chunk(500, function ($leads) use ($out) {
                foreach ($leads as $lead) {
                    fputcsv($out, [
                        $lead->name,
                        $lead->email,
                        $lead->phone,
                        $lead->company,
                        $lead->service?->title,
                        $lead->package,
                        $lead->budget,
                        $lead->timeline,
                        $lead->statusLabel(),
                        $lead->sourceLabel(),
                        $lead->created_at?->format('d/m/Y H:i'),
                    ]);
                }
            });

            fclose($out);
        }, 'prospek-' . now()->format('Y-m-d_His') . '.csv', $headers);
    }
}
