<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadHistory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with('service')->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('source') && $request->source !== 'all') {
            $query->where('source', $request->source);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%")
                    ->orWhere('company', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'ilike', "%{$search}%");
            });
        }

        $leads = $query->paginate(20)->withQueryString();
        $statuses = Lead::STATUSES;

        return view('admin.leads.index', compact('leads', 'statuses'));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Lead::with('service')->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('source') && $request->source !== 'all') {
            $query->where('source', $request->source);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%")
                    ->orWhere('company', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'ilike', "%{$search}%");
            });
        }

        $leads = $query->get();
        $filename = 'leads-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($leads) {
            $out = fopen('php://output', 'w');

            // BOM UTF-8 supaya terbuka rapi di Microsoft Excel
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Nama', 'Email', 'Telepon', 'Perusahaan', 'Layanan', 'Paket', 'Budget', 'Timeline', 'Pesan', 'Sumber', 'Status', 'Dibuat']);

            foreach ($leads as $lead) {
                fputcsv($out, [
                    $lead->name,
                    $lead->email,
                    $lead->phone,
                    $lead->company,
                    $lead->service?->title ?: '',
                    $lead->package,
                    $lead->budget,
                    $lead->timeline,
                    $lead->message,
                    $lead->sourceLabel(),
                    $lead->statusLabel(),
                    $lead->created_at?->format('d/m/Y H:i'),
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function show(Lead $lead)
    {
        $statuses = Lead::STATUSES;

        return view('admin.leads.show', compact('lead', 'statuses'));
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', array_keys(Lead::STATUSES))],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $oldStatus = $lead->status;
        $lead->update(['status' => $validated['status']]);

        LeadHistory::create([
            'lead_id' => $lead->id,
            'status' => $validated['status'],
            'note' => $validated['note'] ?: null,
            'user_id' => auth()->id(),
        ]);

        $message = $oldStatus !== $validated['status']
            ? "Status diubah ke \"" . $lead->statusLabel() . "\"."
            : 'Catatan berhasil ditambahkan.';

        return back()->with('success', $message);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')
            ->with('success', 'Lead berhasil dihapus.');
    }
}
