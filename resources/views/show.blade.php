<x-master-layout>
    <livewire:show :$product_site />
    <x-slot:script>
        <script>
            const ctx = document.getElementById('lineChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($product_site->prices->pluck('date')->toArray()) !!},
                    datasets: [{
                        label: 'Prices',
                        data: {!! json_encode($product_site->prices->pluck('price')->toArray()) !!},
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </x-slot>
</x-master-layout>