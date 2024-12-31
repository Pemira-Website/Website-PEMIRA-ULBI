<div class="bg-white p-10 rounded-lg shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px] w-full">
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
            const ctx = document.getElementById('myChart').getContext('2d');
            const labels = ['Paslon 1', 'Paslon 2'];
            const data = {
                labels: labels,
                datasets: [{
                    label: `Total Suara Masuk: ${chartData.total}`,
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
                            ticks: {
                                stepSize: 700,
                                color: '#333'
                            },
                            title: {
                                display: true,
                                text: '',
                                color: '#333',
                                font: {
                                    size: 14,
                                    family: 'Arial, sans-serif',
                                    weight: 'bold'
                                },
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                borderColor: 'rgba(0, 0, 0, 0.1)'
                            },
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 16,
                                    weight: 'bold',
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#333',
                                font: {
                                    size: 14,
                                    family: 'Arial, sans-serif',
                                    weight: 'bold'
                                },
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
                    elements: {
                        bar: {
                            borderRadius: 3,
                            borderSkipped: false
                        }
                    }
                },
                plugins: [{
                    beforeDraw: function(
                    chart) { // Menggunakan beforeDraw untuk menggambar gambar di belakang chart
                        const ctx = chart.ctx;
                        const images = [
                            '{{ asset('images/paslon1.png') }}',
                            '{{ asset('images/paslon2.png') }}'
                        ];
                        images.forEach((src, index) => {
                            const image = new Image();
                            image.src = src;
                            image.onload = function() {
                                const meta = chart.getDatasetMeta(0);
                                meta.data.forEach((bar, barIndex) => {
                                    if (barIndex === index) {
                                        const x = bar.x;
                                        const y = bar.y - 80;
                                        ctx.drawImage(image, x - 50, y, 90, 90);
                                    }
                                });
                            };
                        });
                    }
                }]
            };


            const myChart = new Chart(ctx, config);

            Livewire.on('berhasilUpdate', (event) => {
                let updatedData = JSON.parse(event.data);
                myChart.data.datasets[0].data = updatedData.data;
                myChart.data.datasets[0].label = `Total Suara Masuk: ${updatedData.total}`;
                myChart.update();
            });
        </script>
    @endpush
</div>
