<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="border rounded p-3 h-100">
            <div class="text-muted small">Nilai {{ $title }}</div>
            <div class="fs-5 fw-bold">{{ $score ?? 'N/A' }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="border rounded p-3 h-100">
            <div class="text-muted small">Benar</div>
            <div class="fs-5 fw-bold text-success">{{ $detail['correct'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="border rounded p-3 h-100">
            <div class="text-muted small">Salah</div>
            <div class="fs-5 fw-bold text-danger">{{ $detail['wrong'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="border rounded p-3 h-100">
            <div class="text-muted small">Tidak Dijawab</div>
            <div class="fs-5 fw-bold text-secondary">{{ $detail['unanswered'] }}</div>
        </div>
    </div>
</div>

@if ($detail['total'] === 0)
    <div class="alert alert-info mb-0">
        Belum ada soal {{ strtolower($title) }}.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="min-width: 280px;">Soal</th>
                    <th style="min-width: 220px;">Jawaban Benar</th>
                    <th style="min-width: 220px;">Jawaban Peserta</th>
                    <th style="width: 120px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail['items'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-wrap" style="white-space: normal; word-break: break-word;">
                            {{ $item['question'] }}
                        </td>
                        <td class="text-wrap" style="white-space: normal; word-break: break-word;">
                            {{ $item['correct_answer'] ?? '-' }}
                        </td>
                        <td class="text-wrap" style="white-space: normal; word-break: break-word;">
                            {{ $item['user_answer'] ?? 'Tidak dijawab' }}
                        </td>
                        <td>
                            @if (!$item['is_answered'])
                                <span class="badge bg-secondary">Tidak Dijawab</span>
                            @elseif ($item['is_correct'])
                                <span class="badge bg-success">Benar</span>
                            @else
                                <span class="badge bg-danger">Salah</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
