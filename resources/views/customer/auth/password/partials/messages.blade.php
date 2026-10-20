{{-- Same message style as the sign-in page. --}}
@if(Session::has('msg'))
    <p role="status" style="color: white;background: #680895;padding: 7px 4px 7px 6px;border-radius: 6px;font-size: 16px;font-weight: 700;">{{ Session::get('msg') }}</p>
@endif
@if($errors->any())
    <div role="alert" style="color: #8a1c1c;background: #fdecec;padding: 8px 10px;border-radius: 6px;font-size: 15px;margin-bottom: 12px;">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
@endif
