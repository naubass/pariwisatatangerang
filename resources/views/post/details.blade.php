<x-app-layout>
    <x-navigation-auth />
<div class="max-w-5xl mx-auto py-10 px-4">
    <!-- Judul Post -->
    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $post->name }}</h1>

    <!-- Gambar Utama -->
    @if($post->thumbnail)
        <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->name }}" class="w-full h-64 object-cover rounded-lg shadow mb-6">
    @endif

    <!-- Info Kategori & Admin -->
    <div class="flex items-center justify-between text-sm text-gray-600 mb-6">
        <div>
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                {{ $post->category->name }}
            </span>
        </div>
    </div>

    <!-- Konten Post -->
    <div class="prose max-w-none mb-10">
        {!! nl2br(e($post->about)) !!}
    </div>

    @foreach ($post->postadmins as $admin)
<div class="instructors-card rounded-[20px] border border-obito-grey p-5 bg-white mb-6 flex flex-col justify-between">
    <!-- Bagian Atas: Foto, Nama, Email -->
    <div class="flex items-center gap-4 mb-4">
        <div class="w-[60px] h-[60px] rounded-full overflow-hidden">
            <img src="{{ Storage::url($admin->admin->photo) }}" class="w-full h-full object-cover" alt="photo">
        </div>
        <div>
            <p class="text-lg font-semibold">{{ $admin->admin->name }}</p>
            <p class="text-sm text-gray-600">{{ $admin->admin->email }}</p>
        </div>
    </div>

    <!-- About -->
    <div class="mb-4">
        <p class="text-gray-700 leading-7">{{ $admin->about }}</p>
    </div>

    <!-- Tombol Aksi: Tiket (kiri) & Chat (kanan) -->
    <div class="flex justify-between items-center mt-auto pt-2">
        @foreach ($pricings as $pricing)
        @php
            $alreadyBooked = in_array($pricing->id, $subscribedPricingIds ?? []);
        @endphp
    
        <a href="{{ $alreadyBooked ? '#' : route('dashboard.post.getticket', ['pricing' => $pricing->id]) }}"
           class="px-4 py-2 rounded transition 
                  {{ $alreadyBooked ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600 text-white' }}"
           {{ $alreadyBooked ? 'onclick=return false' : '' }}>
            🎟️ {{ $alreadyBooked ? 'Sudah Dipesan' : 'Pesan Tiket' }}
        </a>
    @endforeach
    

        <a href="{{ url('chat/' . $admin->admin->id) }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            💬 Chat dengan Admin
        </a>
    </div>
</div>
@endforeach

    


<!-- Testimoni -->
@if($testimonials->count())
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-xl font-semibold mb-4">What People Say</h2>
        <div class="space-y-6">
            @foreach($testimonials as $testimonial)
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <!-- Rating -->
                    <div class="flex items-center mb-2">
                        @for ($i = 0; $i < 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5 text-yellow-400 mr-1">
                            <path d="M12 .587l3.668 7.431 8.2 1.193-5.934 5.782 1.4 8.173L12 18.897l-7.334 3.847 1.4-8.173L.132 9.211l8.2-1.193z"/>
                        </svg>
                        @endfor
                    </div>

                    <!-- Deskripsi -->
                    <div class="border-l-4 border-green-500 pl-4 mb-3">
                        <p class="italic text-gray-700">"{{ $testimonial->description }}"</p>
                    </div>

                    <!-- Info User -->
                    <div class="flex items-center gap-3 mt-2">
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                            <img src="{{ Storage::url($testimonial->photo) }}"
                                 class="w-full h-full object-cover"
                                 alt="photo">
                        </div>
                        <p class="text-sm text-gray-800 font-medium">{{ $testimonial->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@auth
<form method="POST" action="{{ route('comments.store', $post->id) }}" class="mb-6 relative max-w-xl">
    @csrf
    <div class="flex items-start gap-3">
        {{-- Avatar User --}}
        <div class="w-10 h-10 rounded-full overflow-hidden mt-1">
            <img src="{{ auth()->user()->photo ? Storage::url(auth()->user()->photo) : asset('storage/default/profile.jpg') }}" class="w-full h-full object-cover" alt="Foto Profil">
        </div>

        {{-- Komentar Input --}}
        <div class="relative w-full">
            <textarea
                name="comment"
                rows="2"
                class="w-full bg-white border border-gray-300 rounded-xl py-2 px-3 pr-10 text-sm focus:outline-none focus:border-green-500 resize-none transition"
                placeholder="Tambahkan komentar..."
                oninput="toggleSendButton(this)"
                required
            ></textarea>

            {{-- Tombol SVG Send di tengah vertikal --}}
            <button
                type="submit"
                id="send-btn"
                class="absolute top-1/2 right-3 transform -translate-y-1/2 text-green-600 hover:text-green-800 hidden"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </div>
    </div>
</form>



@else
<p class="text-sm text-gray-600">Silakan <a href="{{ route('login') }}" class="text-green-600 underline">login</a> untuk berkomentar.</p>
@endauth

{{-- Komentar dan Balasan --}}
@if($post->comments()->whereNull('parent_id')->count())
<div class="space-y-4 max-h-[500px] overflow-y-auto pr-2"> {{-- Container utama komentar --}}
@foreach($post->comments()->whereNull('parent_id')->latest()->get() as $comment)
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
    {{-- Komentar Utama --}}
    <div class="mb-2">
        <div class="flex items-center gap-3 mb-2"> 
            <div class="w-10 h-10 rounded-full overflow-hidden">
                <img src="{{ $comment->user->photo ? Storage::url($comment->user->photo) : asset('storage/default/profile.jpg') }}" class="w-full h-full object-cover" alt="Foto Profil">
            </div>
            <p class="text-sm font-semibold text-gray-800">{{ $comment->user->name }}</p>
        </div>
        <p class="text-gray-700 mb-1" id="comment-text-{{ $comment->id }}">{{ $comment->comment }}</p>

        <div class="flex items-center gap-2 text-xs text-gray-500">
            <small>{{ $comment->created_at?->diffForHumans() }}</small>
            @if(auth()->id() === $comment->user_id)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus komentar ini?')" class="text-red-600 hover:underline">🗑️ Hapus</button>
                </form>
                <button onclick="document.getElementById('edit-form-{{ $comment->id }}').classList.toggle('hidden')" class="text-blue-600 hover:underline">✏️ Edit</button>
            @endif
        </div>

        {{-- Form Edit Komentar --}}
        @if(auth()->id() === $comment->user_id)
            <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="mt-2 hidden" id="edit-form-{{ $comment->id }}">
                @csrf
                @method('PUT')
                <textarea name="comment" rows="2" class="w-full p-2 border border-gray-300 rounded mb-2" required>{{ $comment->comment }}</textarea>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-1 bg-yellow-500 text-white rounded text-sm">Update Komentar</button>
                </div>
            </form>
        @endif
    </div>

    {{-- Tombol & Form Balasan --}}
    @auth
    <div class="mt-2 mb-1">
        <button onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')" class="inline-flex items-center text-sm text-blue-600 hover:underline hover:text-blue-800 transition duration-200">
            ↩️ Balas
        </button>
    </div>
    <form method="POST" action="{{ route('comments.store', $post->id) }}" class="mt-2 hidden" id="reply-form-{{ $comment->id }}">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea name="comment" rows="2" class="w-full p-2 border border-gray-300 rounded" placeholder="Tulis balasan..." required></textarea>
        <div class="flex justify-end mt-2">
            <button type="submit" class="px-4 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 transition duration-200">Kirim Balasan</button>
        </div>
    </form>
    @endauth

    {{-- Toggle Balasan --}}
    <div id="replies-toggle-{{ $comment->id }}" class="mt-4 space-y-4 hidden max-h-[300px] overflow-y-auto pr-2"> {{-- Scrollable replies --}}
        @foreach($comment->replies as $reply)
            <div class="ml-6 p-3 bg-gray-50 border border-gray-200 rounded">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                        <img src="{{ $reply->user->photo ? Storage::url($reply->user->photo) : asset('storage/default/profile.jpg') }}" class="w-full h-full object-cover" alt="Foto Profil">
                    </div>
                    <p class="text-sm font-semibold text-gray-800">{{ $reply->user->name }}</p>
                </div>
                <p class="text-gray-700 mb-1" id="reply-text-{{ $reply->id }}">{{ $reply->comment }}</p>

                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <small>{{ $reply->created_at?->diffForHumans() }}</small>
                    @if(auth()->id() === $reply->user_id)
                        <form action="{{ route('comments.destroy', $reply->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus balasan ini?')" class="text-red-600 hover:underline">🗑️ Hapus</button>
                        </form>
                        <button onclick="document.getElementById('edit-reply-form-{{ $reply->id }}').classList.toggle('hidden')" class="text-blue-600 hover:underline">✏️ Edit</button>
                    @endif
                </div>

                {{-- Form Edit Balasan --}}
                @if(auth()->id() === $reply->user_id)
                    <form action="{{ route('comments.update', $reply->id) }}" method="POST" class="mt-2 hidden" id="edit-reply-form-{{ $reply->id }}">
                        @csrf
                        @method('PUT')
                        <textarea name="comment" rows="2" class="w-full p-2 border border-gray-300 rounded mb-2" required>{{ $reply->comment }}</textarea>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-1 bg-yellow-500 text-white rounded text-sm">Update Balasan</button>
                        </div>
                    </form>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Tombol Toggle Balasan --}}
    @if($comment->replies->count())
    <div class="mt-3">
        <button onclick="toggleReplies({{ $comment->id }})" class="inline-flex items-center text-sm text-blue-600 hover:underline hover:text-blue-800 transition duration-200">
            👁️ Lihat Balasan ({{ $comment->replies->count() }})
        </button>
    </div>
    @endif
</div>
@endforeach
</div>
@endif

{{-- Script Toggle --}}
<script>
function toggleReplies(commentId) {
    const replies = document.getElementById('replies-toggle-' + commentId);
    replies.classList.toggle('hidden');
}
</script>

<script>
    function toggleSendButton(textarea) {
        const sendBtn = document.getElementById('send-btn');
        if (textarea.value.trim().length > 0) {
            sendBtn.classList.remove('hidden');
        } else {
            sendBtn.classList.add('hidden');
        }
    }
</script>




    <!-- Tombol Kembali di Bawah -->
    <div class="mt-10">
        <a href="{{ route('dashboard') }}"
        class="inline-block bg-red-500 hover:bg-red-400 text-white font-medium px-4 py-2 rounded">
            ← Kembali ke Daftar Post
        </a>
    </div>

</div>


</x-app-layout>
