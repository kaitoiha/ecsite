@php
    if($type === 'shops'){
        $path = 'storage/shops/';
    }
    if($type === 'products'){
        $path ='storage/products/';
    }
@endphp

<div>
    @if(empty($filename))
        <img src="{{asset('images/no_image.jpg')}}">
    @else
        <img src="{{asset($path.$filename)}}" class="h-40 mx-auto object-cover">
    @endif
</div>
