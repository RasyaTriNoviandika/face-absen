<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kehadiran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 5px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4a5568;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
        }
        .status-hadir {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-terlambat {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-izin {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-sakit {
            background-color: #e9d5ff;
            color: #6b21a8;
        }
        .status-alfa {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <h1>Laporan Kehadiran Karyawan</h1>
    <p class="subtitle">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 12%;">NIP</th>
                <th style="width: 20%;">Nama</th>
                <th style="width: 15%;">Departemen</th>
                <th style="width: 10%;">Check In</th>
                <th style="width: 10%;">Check Out</th>
                <th style="width: 13%;">Status</th>
                <th style="width: 10%;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->date->format('d/m/Y') }}</td>
                    <td>{{ $attendance->employee->nip }}</td>
                    <td>{{ $attendance->employee->name }}</td>
                    <td>{{ $attendance->employee->department }}</td>
                    <td>{{ $attendance->check_in }}</td>
                    <td>{{ $attendance->check_out ?? '-' }}</td>
                    <td>
                        <span class="status status-{{ $attendance->status }}">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </td>
                    <td>{{ $attendance->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #666;">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; font-size: 11px; color: #666;">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>