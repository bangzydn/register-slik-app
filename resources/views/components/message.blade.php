@if (@Session::has('success'))
<div class="bg-green-500 border-green-600 p-4 mb-3 rounded-sm shadow-lg text-white font-black ">
    {{ Session::get('succes') }}
</div>    
@endif

@if (@Session::has('error'))
<div class="bg-red-500 border-red-600 p-4 mb-3 rounded-sm shadow-lg text-white font-black">
    {{ Session::get('error') }}
</div>    
@endif