<div class="container">
    <div class="row">
        <div class="col-md-10">
            <h3 class="text-3xl font-bold underline mt-2">
                <a href="{{ $product_site->product_url }}" target="new">{{ $product_site->product->name }}</a>
            </h3>
            <p>
                <span>{{ $product_site->site->name }}</span>
            </p>
        </div>
        <div class="col-md-2">
            <img src="{{ $product_site->thumbnail }}" alt="thumbnail" style="width: 120px">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <canvas id="lineChart"></canvas>
        </div>
    </div>
</div>
