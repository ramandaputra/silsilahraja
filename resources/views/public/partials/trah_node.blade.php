<li class="trah-node">
    <div class="d-inline-flex align-items-center bg-white p-1 rounded shadow-sm {{ $node->id == $currentPersonId ? 'border border-primary' : '' }}">
        
        <a href="{{ route('person.trah', $node->id) }}" class="trah-card {{ $node->id == $currentPersonId ? 'active shadow-none' : '' }} m-0 border-0">
            <small class="{{ $node->id == $currentPersonId ? 'text-warning' : 'text-muted' }} d-block fw-normal mb-1">
                @if($node->id == $currentPersonId)
                    <i class="fa-solid fa-crown"></i> Subjek Fokus
                @else
                    @if($node->jenis_kelamin == 'L')
                        <i class="fa-solid fa-mars text-primary"></i> Laki-laki
                    @else
                        <i class="fa-solid fa-venus text-danger"></i> Perempuan
                    @endif
                @endif
            </small>
            <span class="{{ $node->id == $currentPersonId ? 'fs-5' : '' }}">{{ $node->nama_lengkap }}</span>

            @if($node->nama_ibu_non_raja)
                <div class="{{ $node->id == $currentPersonId ? 'text-white-50 border-white-50' : 'text-muted' }} border-top mt-1 pt-1" style="font-size: 11px; font-weight: normal;">
                    Ibu: {{ $node->nama_ibu_non_raja }}
                </div>
            @endif
        </a>

        @if($node->id == $currentPersonId && $node->status_pernikahan == 'Menikah' && $node->nama_pasangan)
            <div class="px-2 text-danger fs-4">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div class="trah-card m-0 border-0 bg-light text-start" style="min-width: 150px; color: #333 !important;">
                <small class="text-muted d-block fw-normal mb-1">
                    <i class="fa-solid fa-user-friends text-secondary"></i> Daftar Pasangan
                </small>
                <span class="text-dark d-block" style="white-space: normal; line-height: 1.4; font-size: 13px;">
                    {!! str_replace(',', '<br><i class="fa-solid fa-heart text-danger small me-1"></i>', $node->nama_pasangan) !!}
                </span>
            </div>
        @endif
    </div>

    @php
        // JALUR AMAN: Mengambil anak-anak secara langsung lewat query database untuk menghindari error relasi ganda PHP
        $directChildren = \App\Models\Person::where('father_id', $node->id)
                            ->orWhere('mother_id', $node->id)
                            ->orderBy('tanggal_lahir', 'asc')
                            ->get();
    @endphp

    @if($directChildren->count() > 0)
        <ul>
            @foreach($directChildren as $subChild)
                @include('public.partials.trah_node', ['node' => $subChild, 'currentPersonId' => $currentPersonId])
            @endforeach
        </ul>
    @endif
</li>
