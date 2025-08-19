<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-dark">
            <tr>
                <th>Élève</th>
                <th>Soumission</th>
                <th>Note</th>
                <th>Feedback</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $submission)
                <tr>
                    <td>
                        <div class="fw-semibold">
                            {{ $submission->student->last_name }} {{ $submission->student->first_name }}
                        </div>
                        <div class="text-muted small">#{{ $submission->student->id }}</div>
                    </td>
                    <td>
                        @if($submission->file_path)
                            <a href="{{ asset('storage/'.$submission->file_path) }}" target="_blank">📄 Voir</a>
                        @else
                            {{ $submission->answer ?? '—' }}
                        @endif
                    </td>
                    <td>{{ $submission->grade ?? '—' }}</td>
                    <td>{{ $submission->feedback ?? '—' }}</td>
                    <td>
                        @php
                            $map = ['pending'=>'warning','submitted'=>'info','graded'=>'success'];
                        @endphp
                        <span class="badge bg-{{ $map[$submission->status] ?? 'secondary' }}">
                            {{ [
                                'pending'=>'En attente',
                                'submitted'=>'Soumis',
                                'graded'=>'Corrigé'
                            ][$submission->status] ?? $submission->status }}
                        </span>
                    </td>
                    <td class="text-end">
                        <form action="{{ route('assignments.submissions.grade', [$submission->assignment, $submission]) }}"
                              method="POST"
                              class="d-inline-flex gap-2 align-items-center">
                            @csrf
                            <input type="number" name="grade" min="0" max="20" step="0.01"
                                   value="{{ $submission->grade }}"
                                   class="form-control form-control-sm" style="width: 90px;">
                            <input type="text" name="feedback" value="{{ $submission->feedback }}"
                                   placeholder="Feedback"
                                   class="form-control form-control-sm" style="width: 140px;">
                            <select name="status" class="form-select form-select-sm" style="width: 140px;">
                                <option value="pending"   @selected($submission->status==='pending')>En attente</option>
                                <option value="submitted" @selected($submission->status==='submitted')>Soumis</option>
                                <option value="graded"    @selected($submission->status==='graded')>Corrigé</option>
                            </select>
                            <button class="btn btn-sm btn-success">
                                <i class="bi bi-save"></i> Enregistrer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-emoji-neutral"></i> Aucune soumission.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
