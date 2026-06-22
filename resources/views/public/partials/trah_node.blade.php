<li class="trah-node">
    <!-- JALUR INDIVIDU / PASANGAN BERDAMPINGAN TANPA BORDER BOX SAMA SEKALI -->
    <div class="inline-flex items-center gap-2">
        
        <!-- Kartu Individu Utama -->
        <a href="{{ route('person.trah', $node->id) }}" class="trah-card {{ $node->id == $currentPersonId ? 'active' : '' }}">
            <small class="{{ $node->id == $currentPersonId ? 'text-amber-400 font-semibold' : 'text-gray-400' }} block text-[10px] tracking-wider uppercase mb-0.5">
                @if($node->id == $currentPersonId)
                    👑 Subjek Fokus
                @else
                    {{ $node->jenis_kelamin == 'L' ? '♂️ Laki-laki' : '♀️ Perempuan' }}
                @endif
            </small>
            <span class="block">{{ $node->nama_lengkap }}</span>

            @if($node->nama_ibu_non_raja)
                <div class="border-t {{ $node->id == $currentPersonId ? 'border-white/20 text-white/70' : 'border-gray-100 text-gray-400' }} mt-1 pt-0.5 text-[10px] font-normal">
                    Ibu: {{ $node->nama_ibu_non_raja }}
                </div>
            @endif
        </a>

        <!-- Tampilkan Pasangan Langsung Di Sampingnya Jika Ini Subjek Fokus -->
        @if($node->id == $currentPersonId && $node->status_pernikahan == 'Menikah' && $node->nama_pasangan)
            <div class="text-red-500 text-xs"><i class="fa-solid fa-heart"></i></div>
            <div class="trah-card bg-gray-50 border-dashed">
                <small class="text-gray-400 block text-[10px] tracking-wider uppercase font-medium mb-0.5">💍 Pasangan</small>
                <span class="block text-gray-600 text-xs font-normal">{!! str_replace(',', '<br>', $node->nama_pasangan) !!}</span>
            </div>
        @endif
    </div>

    @php
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