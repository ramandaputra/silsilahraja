@php
    $directChildren = $childrenMap[$node->id] ?? [];
    $branchType = $branchTypeMap[$node->id] ?? 'none';
@endphp

<div class="trah-node-wrapper">
    <!-- Kotak Nama Tokoh (Format Manuskrip Silsilah - Rata Kiri) -->
    <a href="{{ route('person.trah', $node->id) }}" 
       class="trah-person-box text-left {{ $node->id == $currentPersonId ? 'active' : '' }}" 
       title="{{ $node->nama_lengkap }}{{ !empty($node->gelar_pembeda) ? ' ('.$node->gelar_pembeda.')' : '' }}{{ $node->nasab ? ' - '.$node->nasab : '' }}">
        <div class="flex items-center gap-1.5 leading-tight">
            <span class="w-3.5 flex items-center justify-center shrink-0">
                @if($node->jenis_kelamin == 'L')
                    <i class="bi bi-gender-male text-black text-xs shrink-0" title="Laki-laki"></i>
                @elseif($node->jenis_kelamin == 'P')
                    <i class="bi bi-gender-female text-black text-xs shrink-0" title="Perempuan"></i>
                @endif
            </span>
            <span class="trah-name text-left">{{ strtoupper($node->nama_lengkap) }}</span>
        </div>
        @if(!empty($node->gelar_pembeda))
            <div class="flex items-center gap-1.5 leading-tight mt-0.5">
                <span class="w-3.5 shrink-0"></span>
                <span class="trah-gelar text-left">{{ strtoupper($node->gelar_pembeda) }}</span>
            </div>
        @endif
        @if($node->has_duplicate_name && $node->nasab)
            <div class="flex items-center gap-1.5 leading-tight mt-0.5">
                <span class="w-3.5 shrink-0"></span>
                <span class="trah-nasab text-left">{{ $node->nasab }}</span>
            </div>
        @endif
        @if(!empty($node->nama_pasangan))
            @php
                $spouses = array_filter(array_map('trim', explode(',', $node->nama_pasangan)));
            @endphp
            @foreach($spouses as $sp)
                <div class="flex items-center gap-1.5 leading-tight mt-0.5">
                    <span class="w-3.5 flex items-center justify-center shrink-0">
                        <i class="bi bi-link-45deg text-sm text-gray-500 shrink-0" title="Pasangan"></i>
                    </span>
                    <span class="trah-spouse text-left">{{ strtoupper($sp) }}</span>
                </div>
            @endforeach
        @endif
    </a>

    <!-- Percabangan Keturunan Sesuai Kaidah Naskah Zuriat -->
    @if(!empty($directChildren))
        @if($branchType === 'single')
            <!-- 1 Anak: Garis Vertikal Lurus ke Bawah -->
            <div class="trah-single-connector"></div>
            @include('public.partials.trah_node', [
                'node' => $directChildren[0],
                'currentPersonId' => $currentPersonId,
                'childrenMap' => $childrenMap,
                'branchTypeMap' => $branchTypeMap,
                'relatives' => $relatives,
                'peopleById' => $peopleById ?? []
            ])

        @elseif($branchType === 'vertical_stack')
            <!-- Anak-anak Terminal Leaves: Kontainer Rata Tengah dengan Garis, Nama Adik Beradik Rata Kiri (Hanya Anak Pertama Mengikuti Garis) -->
            <div class="trah-single-connector"></div>
            <ul class="trah-leaf-stack">
                @foreach($directChildren as $leafChild)
                    <li class="trah-leaf-item">
                        <a href="{{ route('person.trah', $leafChild->id) }}" 
                           class="trah-person-box text-left {{ $leafChild->id == $currentPersonId ? 'active' : '' }}" 
                           title="{{ $leafChild->nama_lengkap }}">
                            <div class="flex items-center gap-1.5 leading-tight">
                                <span class="w-3.5 flex items-center justify-center shrink-0">
                                    @if($leafChild->jenis_kelamin == 'L')
                                        <i class="bi bi-gender-male text-black text-xs shrink-0" title="Laki-laki"></i>
                                    @elseif($leafChild->jenis_kelamin == 'P')
                                        <i class="bi bi-gender-female text-black text-xs shrink-0" title="Perempuan"></i>
                                    @endif
                                </span>
                                <span class="trah-name text-left">{{ strtoupper($leafChild->nama_lengkap) }}</span>
                            </div>
                            @if(!empty($leafChild->gelar_pembeda))
                                <div class="flex items-center gap-1.5 leading-tight mt-0.5">
                                    <span class="w-3.5 shrink-0"></span>
                                    <span class="trah-gelar text-left">{{ strtoupper($leafChild->gelar_pembeda) }}</span>
                                </div>
                            @endif
                            @if($leafChild->has_duplicate_name && $leafChild->nasab)
                                <div class="flex items-center gap-1.5 leading-tight mt-0.5">
                                    <span class="w-3.5 shrink-0"></span>
                                    <span class="trah-nasab text-left">{{ $leafChild->nasab }}</span>
                                </div>
                            @endif
                            @if(!empty($leafChild->nama_pasangan))
                                @php
                                    $leafSpouses = array_filter(array_map('trim', explode(',', $leafChild->nama_pasangan)));
                                @endphp
                                @foreach($leafSpouses as $lsp)
                                    <div class="flex items-center gap-1.5 leading-tight mt-0.5">
                                        <span class="w-3.5 flex items-center justify-center shrink-0">
                                            <i class="bi bi-link-45deg text-sm text-gray-500 shrink-0" title="Pasangan"></i>
                                        </span>
                                        <span class="trah-spouse text-left">{{ strtoupper($lsp) }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>

        @elseif($branchType === 'horizontal')
            <!-- Anak-anak Memiliki Keturunan Lanjutan: Percabangan Horizontal Crossbar -->
            <div class="trah-branch-horizontal-container">
                <div class="trah-single-connector"></div>
                <ul class="trah-branch-horizontal">
                    @foreach($directChildren as $child)
                        <li class="trah-node-horizontal">
                            @include('public.partials.trah_node', [
                                'node' => $child,
                                'currentPersonId' => $currentPersonId,
                                'childrenMap' => $childrenMap,
                                'branchTypeMap' => $branchTypeMap,
                                'relatives' => $relatives,
                                'peopleById' => $peopleById ?? []
                            ])
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
</div>
