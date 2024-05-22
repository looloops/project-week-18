@include('includes.init')
@include('includes.navbar')

<img src=" {{ $product->img }}"></img>
<h1>{{ $product->name }}</h1>




@include('includes.footer')