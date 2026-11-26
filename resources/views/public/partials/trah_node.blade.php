<li class="trah-node">
    <!-- JALUR INDIVIDU / PASANGAN BERDAMPINGAN TANPA BORDER BOX SAMA SEKALI -->
    <div class="inline-flex items-center gap-2">
        
        <!-- Kartu Individu Utama -->
        <a href="{{ route('person.trah', $node->id) }}" class="trah-card {{ $node->id == $currentPersonId ? 'active' : '' }}">
            <div class="flex items-start gap-1.5 whitespace-nowrap">
                @if($node->jenis_kelamin == 'L')
                    <i class="bi bi-gender-male text-blue-500 text-sm shrink-0 mt-0.5"></i>
                @else
                    <i class="bi bi-gender-female text-rose-500 text-sm shrink-0 mt-0.5"></i>
                @endif
                <div class="flex flex-col text-left">
                    <span class="font-bold leading-tight">{{ $node->nama_lengkap }}</span>
                    @if(!empty($node->gelar_pembeda))
                        <span class="text-[10px] text-primary font-semibold leading-tight mt-0.5 text-left">{{ $node->gelar_pembeda }}</span>
                    @endif
                    @if($node->has_duplicate_name && $node->nasab)
                        <span class="text-[9px] text-amber-700 font-semibold leading-tight mt-0.5 text-left">
                            {{ $node->nasab }}
                        </span>
                    @endif
                </div>
            </div>
        </a>

        {{-- Tampilkan Pasangan Langsung Di Sampingnya --}}
        @if($node->id == $currentPersonId && $node->status_pernikahan == 'Menikah' && $node->nama_pasangan)
            <div class="text-red-500 text-xs"><i class="fa-solid fa-heart"></i></div>
            <div class="trah-card bg-gray-50 border-dashed">
                <div class="flex items-start gap-1.5 text-gray-600 text-xs font-normal">
                    @if($node->jenis_kelamin == 'L')
                        <i class="bi bi-gender-female text-rose-500 text-sm shrink-0 mt-0.5"></i>
                    @else
                        <i class="bi bi-gender-male text-blue-500 text-sm shrink-0 mt-0.5"></i>
                    @endif
                    <span>{!! str_replace(',', '<br>', $node->nama_pasangan) !!}</span>
                </div>
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
