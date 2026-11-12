<!DOCTYPE html>
<html>
<head>
    <title>Laporan Resep Jelajah Rasa</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; color: #41240e; }
        .subtitle { text-align: center; margin-bottom: 20px; font-size: 12px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f5edde; color: #41240e; font-weight: bold; }
        .text-left { text-align: left; }
        .badge-published { color: #55643b; font-weight: bold; }
        .badge-draft { color: #ba1a1a; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Laporan Data Resep - Jelajah Rasa</h2>
    <div class="subtitle">Dicetak pada: {{ date('d F Y, H:i') }} WIB</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%" class="text-left">Judul Resep</th>
                <th width="15%">Kategori</th>
                <th width="10%">Kesulitan</th>
                <th width="10%">Waktu</th>
                <th width="10%">Kalori</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recipes as $index => $recipe)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $recipe->title }}</td>
                    <td>{{ $recipe->category->name ?? 'Umum' }}</td>
                    <td>{{ $recipe->difficulty }}</td>
                    <td>{{ $recipe->duration_minutes }} mnt</td>
                    <td>{{ $recipe->calories ?? '-' }} kkal</td>
                    <td class="{{ $recipe->status === 'published' ? 'badge-published' : 'badge-draft' }}">
                        {{ ucfirst($recipe->status) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>