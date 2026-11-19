<li class="trah-node">
    <!-- JALUR INDIVIDU / PASANGAN BERDAMPINGAN TANPA BORDER BOX SAMA SEKALI -->
    <div class="inline-flex items-center gap-2">
        
        <!-- Kartu Individu Utama -->
        <a href="{{ route('person.trah', $node->id) }}" class="trah-card {{ $node->id == $currentPersonId ? 'active' : '' }}">
            <small class="text-gray-400 block text-[10px] tracking-wider uppercase mb-0.5">
                @if($node->jenis_kelamin == 'L')
                    <i class="bi bi-gender-male text-blue-500"></i>
                @else
                    <i class="bi bi-gender-female text-rose-500"></i>
                @endif
                @php
                    $relInfo = $relatives[$node->id] ?? null;
                    $relText = ($relInfo && !empty($relInfo['relation']) && $relInfo['relation'] !== 'Subjek Fokus') 
                        ? $relInfo['relation'] 
                        : ($node->id == $currentPersonId ? '' : ($node->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'));
                @endphp
                @if(!empty($relText))
                    <span>{{ $relText }}</span>
                @endif
            </small>
            <span class="block font-bold">{{ $node->nama_lengkap }}</span>
            @if(!empty($node->gelar_pembeda))
                <span class="block text-[10px] text-primary font-semibold">{{ $node->gelar_pembeda }}</span>
            @elseif($node->has_duplicate_name && $node->nasab)
                <span class="block text-[9px] text-amber-700 font-semibold">
                    {{ $node->nasab }}
                </span>
            @endif

            @if(!empty($node->nama_ibu_non_raja))
                <div class="border-t border-gray-100 text-gray-400 mt-1 pt-0.5 text-[10px] font-normal">
                    Ibu: {{ $node->nama_ibu_non_raja }}
                </div>
            @elseif(!empty($node->mother_id) && isset($peopleById[$node->mother_id]))
                <div class="border-t border-gray-100 text-gray-400 mt-1 pt-0.5 text-[10px] font-normal">
                    Ibu: {{ $peopleById[$node->mother_id]->nama_lengkap }}
                </div>
            @endif
        </a>

        {{-- Tampilkan Pasangan Langsung Di Sampingnya --}}
        @if($node->id == $currentPersonId && $node->status_pernikahan == 'Menikah' && $node->nama_pasangan)
            <div class="text-red-500 text-xs"><i class="fa-solid fa-heart"></i></div>
            <div class="trah-card bg-gray-50 border-dashed">
                <small class="text-gray-400 block text-[10px] tracking-wider uppercase font-medium mb-0.5">
                    @if($node->jenis_kelamin == 'L')
                        <i class="bi bi-gender-female text-rose-500"></i>
                    @else
                        <i class="bi bi-gender-male text-blue-500"></i>
                    @endif
                    <span>Pasangan</span>
                </small>
                <span class="block text-gray-600 text-xs font-normal">{!! str_replace(',', '<br>', $node->nama_pasangan) !!}</span>
            </div>
        @endif
    </div>

    @php
        $directChildren = $childrenMap[$node->id] ?? [];
    @endphp

    @if(!empty($directChildren))
        <ul>
            @foreach($directChildren as $subChild)
                @include('public.partials.trah_node', [
                    'node' => $subChild,
                    'currentPersonId' => $currentPersonId,
                    'childrenMap' => $childrenMap,
                    'relatives' => $relatives,
                    'peopleById' => $peopleById ?? []
                ])
            @endforeach
        </ul>
    @endif
</li>