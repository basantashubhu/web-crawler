<div class="container">
    <ul>
        @foreach ($products as $product_site)
            <li>
                <div class="row">
                    <div class="col-auto">
                        <span>{{ $product_site->site->name }}</span> &emsp;
                        <span>sku: {{ $product_site->product->sku }}</span><br>
                        <a href="{{ $product_site->product_url }}" target="new">{{ $product_site->product->name }}</a>
                        <br>
                        @if($last_price = $product_site->prices()->latest()->first())
                            <span>{{ $last_price->currency }} {{ $last_price->price }}</span>
                            @if($second_last = $product_site->prices()->where('id', '!=', $last_price->id)->where('price', '!=', $last_price->price)->latest()->first())
                                @if($last_price->price > $second_last->price)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-arrow-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/>
                                </svg>
                                @elseif($last_price->price < $second_last->price)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-arrow-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1"/>
                                </svg>
                                @endif
                            @endif
                        @endif
                        <br>
                        <a href="{{ route('show', $product_site) }}">See More</a>
                    </div>
                    <div class="col text-md-end">
                        <img src="{{ $product_site->thumbnail }}" alt="thumbnail" style="width: 100px">
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
