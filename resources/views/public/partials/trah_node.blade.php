@php
    $directChildren = $childrenMap[$node->id] ?? [];
    $branchType = $branchTypeMap[$node->id] ?? 'none';
@endphp

<div class="trah-node-wrapper">
    <!-- Kotak Nama Tokoh (Format Manuskrip Silsilah) -->
    <a href="{{ route('person.trah', $node->id) }}" 
       class="trah-person-box {{ $node->id == $currentPersonId ? 'active' : '' }}" 
       title="{{ $node->nama_lengkap }}{{ !empty($node->gelar_pembeda) ? ' ('.$node->gelar_pembeda.')' : '' }}{{ $node->nasab ? ' - '.$node->nasab : '' }}">
        <span class="trah-name">{{ strtoupper($node->nama_lengkap) }}</span>
        @if(!empty($node->gelar_pembeda))
            <span class="trah-gelar">{{ strtoupper($node->gelar_pembeda) }}</span>
        @endif
        @if($node->has_duplicate_name && $node->nasab)
            <span class="trah-nasab">{{ $node->nasab }}</span>
        @endif
        @if(!empty($node->nama_pasangan))
            @php
                $spouses = array_filter(array_map('trim', explode(',', $node->nama_pasangan)));
            @endphp
            @foreach($spouses as $sp)
                <span class="trah-spouse">(+) {{ strtoupper($sp) }}</span>
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
            <!-- Anak-anak Terminal Leaves: Daftar Vertikal Merapat ke Bawah -->
            <div class="trah-single-connector"></div>
            <ul class="trah-leaf-stack">
                @foreach($directChildren as $leafChild)
                    <li class="trah-leaf-item">
                        <a href="{{ route('person.trah', $leafChild->id) }}" 
                           class="trah-person-box {{ $leafChild->id == $currentPersonId ? 'active' : '' }}" 
                           title="{{ $leafChild->nama_lengkap }}">
                            <span class="trah-name">{{ strtoupper($leafChild->nama_lengkap) }}</span>
                            @if(!empty($leafChild->gelar_pembeda))
                                <span class="trah-gelar">{{ strtoupper($leafChild->gelar_pembeda) }}</span>
                            @endif
                            @if($leafChild->has_duplicate_name && $leafChild->nasab)
                                <span class="trah-nasab">{{ $leafChild->nasab }}</span>
                            @endif
                            @if(!empty($leafChild->nama_pasangan))
                                @php
                                    $leafSpouses = array_filter(array_map('trim', explode(',', $leafChild->nama_pasangan)));
                                @endphp
                                @foreach($leafSpouses as $lsp)
                                    <span class="trah-spouse">(+) {{ strtoupper($lsp) }}</span>
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
