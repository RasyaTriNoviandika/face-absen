<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $employeeId = $request->input('employee_id');

        // Query untuk statistik
        $query = Attendance::whereBetween('date', [$startDate, $endDate]);

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        // Statistik keseluruhan
        $stats = [
            'total_present' => (clone $query)->whereIn('status', ['hadir', 'terlambat'])->count(),
            'total_late' => (clone $query)->where('status', 'terlambat')->count(),
            'total_absent' => (clone $query)->where('status', 'alfa')->count(),
            'total_leave' => (clone $query)->whereIn('status', ['izin', 'sakit'])->count(),
        ];

        // Data per karyawan
        $employeeReports = Employee::where('is_active', true)
            ->withCount([
                'attendances as present_count' => function($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate])
                      ->whereIn('status', ['hadir', 'terlambat']);
                },
                'attendances as late_count' => function($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate])
                      ->where('status', 'terlambat');
                },
                'attendances as absent_count' => function($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate])
                      ->where('status', 'alfa');
                },
            ])
            ->when($employeeId, function($q) use ($employeeId) {
                return $q->where('id', $employeeId);
            })
            ->paginate(15);

        $employees = Employee::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.reports.index', compact(
            'stats',
            'employeeReports',
            'employees',
            'startDate',
            'endDate',
            'employeeId'
        ));
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:csv,excel,pdf',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $employeeId = $request->input('employee_id');
        $format = $request->input('format');

        $attendances = Attendance::with('employee')
            ->whereBetween('date', [$startDate, $endDate])
            ->when($employeeId, function($q) use ($employeeId) {
                return $q->where('employee_id', $employeeId);
            })
            ->orderBy('date')
            ->orderBy('check_in')
            ->get();

        switch ($format) {
            case 'csv':
                return $this->exportCsv($attendances, $startDate, $endDate);
            case 'excel':
                return $this->exportExcel($attendances, $startDate, $endDate);
            case 'pdf':
                return $this->exportPdf($attendances, $startDate, $endDate);
            default:
                return redirect()->back()->with('error', 'Format tidak valid');
        }
    }

    private function exportCsv($attendances, $startDate, $endDate)
{
    $filename = "attendance-report-{$startDate}-to-{$endDate}.csv";
    
    return response()->streamDownload(function() use ($attendances) {
        $file = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        fputcsv($file, ['Tanggal', 'NIP', 'Nama', 'Departemen', 'Check In', 'Check Out', 'Status', 'Catatan']);
        
        // Data with null safety
        foreach ($attendances as $attendance) {
            fputcsv($file, [
                $attendance->date->format('Y-m-d'),
                $attendance->employee->nip ?? '-',
                $attendance->employee->name ?? '-',
                $attendance->employee->department ?? '-',
                $attendance->check_in ?? '-',
                $attendance->check_out ?? '-',
                ucfirst($attendance->status ?? '-'),
                $attendance->notes ?? '-',
            ]);
        }
        
        fclose($file);
    }, $filename, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ]);
}

    private function exportExcel($attendances, $startDate, $endDate)
    {
        // Implementasi export Excel menggunakan PhpSpreadsheet
        $filename = "attendance-report-{$startDate}-to-{$endDate}.xlsx";
        
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($attendances) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Tanggal', 'NIP', 'Nama', 'Departemen', 'Check In', 'Check Out', 'Status', 'Catatan']);
            
            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $attendance->date->format('Y-m-d'),
                    $attendance->employee->nip,
                    $attendance->employee->name,
                    $attendance->employee->department,
                    $attendance->check_in,
                    $attendance->check_out ?? '-',
                    ucfirst($attendance->status),
                    $attendance->notes ?? '-',
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportPdf($attendances, $startDate, $endDate)
    {
        // Implementasi basic PDF export menggunakan DomPDF atau TCPDF
        // Untuk simplicity, return HTML yang bisa di-print
        $html = view('admin.reports.pdf', compact('attendances', 'startDate', 'endDate'))->render();
        
        $filename = "attendance-report-{$startDate}-to-{$endDate}.pdf";
        
        // Jika menggunakan DomPDF:
        // $pdf = PDF::loadHTML($html);
        // return $pdf->download($filename);
        
        // Sementara return HTML untuk print
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', "inline; filename=\"{$filename}\"");
    }
}