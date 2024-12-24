<div class="flex flex-col items-center">
    <div class="text-2xl font-bold mb-2">Presma Kema ULBI</div>
    <div>
        <canvas id="myChart" class="w-128 h-96"></canvas>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Interval untuk mengirim event ke server
            setInterval(() => Livewire.dispatch('ubahData'), 3000);

            // Inisialisasi chart
            let chartData = JSON.parse(@json($totalVote));
            console.log(chartData);
            const ctx = document.getElementById('myChart').getContext('2d');
            const labels = ['Paslon 1', 'Paslon 2'];
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Votes',
                    data: chartData.data,
                    backgroundColor: ['rgba(75, 192, 192, 0.8)', 'rgba(255, 99, 132, 0.8)'],
                    borderColor: ['rgb(75, 192, 192)', 'rgb(255, 99, 132)'],
                    borderWidth: 2,
                    hoverBackgroundColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                }]
            };
            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 3458,
                            ticks: { stepSize: 700, color: '#333' },
                            title: {
                                display: true,
                                text: 'Jumlah Suara',
                                color: '#333',
                                font: { size: 14, family: 'Arial, sans-serif', weight: 'bold' },
                            },
                            grid: { color: 'rgba(0, 0, 0, 0.1)', borderColor: 'rgba(0, 0, 0, 0.1)' },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Kandidat',
                                color: '#333',
                                font: { size: 14, family: 'Arial, sans-serif', weight: 'bold' },
                            },
                            ticks: { color: '#333' },
                            grid: { color: 'rgba(0, 0, 0, 0.1)', borderColor: 'rgba(0, 0, 0, 0.1)' },
                            barPercentage: 0.4,
                            categoryPercentage: 0.5,
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#333',
                                font: { size: 14, family: 'Arial, sans-serif', weight: 'bold' },
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#fff',
                            borderWidth: 1,
                            padding: 10,
                            caretSize: 10,
                            cornerRadius: 4,
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuad',
                    },
                    elements: { bar: { borderRadius: 8, borderSkipped: false } }
                }
            };

            const myChart = new Chart(ctx, config);

            // Mendengarkan event "berhasilUpdate"
            Livewire.on('berhasilUpdate', (event) => {
                let updatedData = JSON.parse(event.data);
                console.log(updatedData);
                myChart.data.datasets[0].data = updatedData.data;
                myChart.update();
            });
        </script>
    @endpush
</div>
