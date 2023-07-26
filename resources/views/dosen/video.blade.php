@foreach ($modul_video as $data)
    <video width="329" height="240" autoplay-muted >
        <source src="{{ asset('videos') }}/{{ $data['file_video'] }}" type="video/mp4">
    </video>
@endforeach