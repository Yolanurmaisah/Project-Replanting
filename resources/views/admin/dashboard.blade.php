@extends('layouts.admin.app')
@section('title', 'Dashboard')

@section('content')
<div class="head">
    <div>
        <h1>Dashboard</h1>
        <div class="mu">Pantau umur kebun dan tahapan replanting kelompok tani</div>
    </div>
    <a href="{{ route('kebun.create') }}" class="btn">+ Tambah Kebun</a>
</div>

<section class="top3">
    <div class="hero"><b class="sp"></b>
        <div>
            <span class="tag">{{ $perStatus['siap'] ? 'Peringatan' : 'Info' }}</span>
            <h3>{{ $perStatus['siap'] ? $perStatus['siap'].' kebun sudah siap replanting' : 'Belum ada kebun yang siap replanting' }}</h3>
        </div>
        <a href="{{ route('kebun.index', ['status' => 'siap']) }}">Lihat daftar kebun →</a>
    </div>
    <div class="card">
        <div class="mu">Total Petani</div>
        <div class="big">{{ $jumlahPetani }}</div>
        <div class="up">{{ $kebun->count() }} kebun terdaftar</div>
    </div>
    <div class="card">
        <div class="mu">Mendekati Replanting</div>
        <div class="big">{{ $perStatus['mendekati'] }}</div>
        <div class="dn">Umur {{ $batas['mendekati'] }}–{{ $batas['siap'] - 1 }} tahun</div>
    </div>
</section>

<section class="two">
    <div class="card">
        <h2>Kebun Berdasarkan Rentang Umur</h2>
        <div class="mu">Total {{ $kebun->count() }} kebun</div>
        <div class="cv"><canvas id="bar" role="img" aria-label="Grafik batang jumlah kebun per rentang umur"></canvas></div>
    </div>
    <div class="card">
        <h2>Status Umur Kebun</h2>
        <div class="mu">Normal, Mendekati, Siap</div>
        <div class="cv"><canvas id="pie" role="img" aria-label="Grafik donat status umur kebun"></canvas></div>
    </div>
</section>

<section class="card">
    <div class="head" style="align-items:center;margin-bottom:8px">
        <h2>Kebun Siap Replanting</h2>
        <a href="{{ route('laporan.siap') }}" class="btn">Cetak Laporan</a>
    </div>
    <div class="sc">
        <table>
            <thead>
                <tr><th>Kebun</th><th>Pemilik</th><th>Luas</th><th>Tahun Tanam</th><th>Umur</th><th>Tahap</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($siap as $k)
                    <tr>
                        <td><a href="{{ route('kebun.show', $k) }}"><b>{{ $k->nama_kebun }}</b></a></td>
                        <td>{{ $k->petani->nama }}</td>
                        <td>{{ number_format($k->luas_ha, 1, ',', '.') }} ha</td>
                        <td>{{ $k->tahun_tanam }}</td>
                        <td><span class="b r">{{ $k->umur }} th</span></td>
                        <td>{{ $k->tahapan->nama_tahap }}</td>
                        <td><a href="{{ route('kebun.tahap', $k) }}" class="b ok">Update tahap</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="mu" style="text-align:center;padding:24px">Belum ada kebun yang siap replanting.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {
    try {
        var mu = getComputedStyle(document.documentElement).getPropertyValue('--mu').trim() || '#5B6B63';
        Chart.defaults.color = mu;
        Chart.defaults.font.family = 'Inter,system-ui,sans-serif';

        new Chart(document.getElementById('bar'), {
            type: 'bar',
            data: {
                labels: @json($rentang['labels']),
                datasets: [{
                    data: @json($rentang['data']),
                    borderRadius: 8,
                    backgroundColor: ['#1F7A55', '#1F7A55', '#1F7A55', '#B4EB0F', '#F97316']
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(120,150,135,.2)' } },
                    x: { grid: { display: false } }
                }
            }
        });

        new Chart(document.getElementById('pie'), {
            type: 'doughnut',
            data: {
                labels: ['Normal', 'Mendekati', 'Siap'],
                datasets: [{
                    data: [{{ $perStatus['normal'] }}, {{ $perStatus['mendekati'] }}, {{ $perStatus['siap'] }}],
                    backgroundColor: ['#1F7A55', '#B4EB0F', '#F97316'],
                    borderWidth: 0
                }]
            },
            options: { maintainAspectRatio: false, cutout: '68%', plugins: { legend: { position: 'bottom' } } }
        });
    } catch (e) { console.error(e); }
})();
</script>
@endpush
