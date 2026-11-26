<li class="trah-node">
    <!-- JALUR INDIVIDU / PASANGAN BERDAMPINGAN -->
    <div class="inline-flex items-center gap-1.5">
        
        <!-- Kartu Individu Utama -->
        <a href="{{ route('person.trah', $node->id) }}" class="trah-card {{ $node->id == $currentPersonId ? 'active' : '' }}" title="{{ $node->nama_lengkap }}{{ !empty($node->gelar_pembeda) ? ' ('.$node->gelar_pembeda.')' : '' }}{{ $node->nasab ? ' - '.$node->nasab : '' }}">
            <div class="flex items-start gap-1.5">
                @if($node->jenis_kelamin == 'L')
                    <i class="bi bi-gender-male text-blue-500 text-xs shrink-0 mt-0.5"></i>
                @else
                    <i class="bi bi-gender-female text-rose-500 text-xs shrink-0 mt-0.5"></i>
                @endif
                <div class="flex flex-col text-left min-w-0 flex-1">
                    <span class="font-bold leading-tight break-words text-[11.5px] text-gray-900">{{ $node->nama_lengkap }}</span>
                    @if(!empty($node->gelar_pembeda))
                        <span class="text-[9px] text-primary font-semibold leading-tight mt-0.5 text-left break-words">{{ $node->gelar_pembeda }}</span>
                    @endif
                    @if($node->has_duplicate_name && $node->nasab)
                        <span class="text-[8.5px] text-amber-700 font-semibold leading-tight mt-0.5 text-left break-words">
                            {{ $node->nasab }}
                        </span>
                    @endif
                </div>
            </div>
        </a>

        {{-- Tampilkan Pasangan Langsung Di Sampingnya --}}
        @if($node->id == $currentPersonId && $node->status_pernikahan == 'Menikah' && $node->nama_pasangan)
            <div class="text-rose-500 text-[10px] shrink-0" title="Pasangan"><i class="fa-solid fa-heart"></i></div>
            <div class="trah-card bg-gray-50/90 border-dashed max-w-[130px] p-1.5">
                <div class="flex items-start gap-1 text-gray-600 text-[10.5px] font-normal">
                    @if($node->jenis_kelamin == 'L')
                        <i class="bi bi-gender-female text-rose-500 text-xs shrink-0 mt-0.5"></i>
                    @else
                        <i class="bi bi-gender-male text-blue-500 text-xs shrink-0 mt-0.5"></i>
                    @endif
                    <span class="break-words leading-tight text-left">{!! str_replace(',', '<br>', $node->nama_pasangan) !!}</span>
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
