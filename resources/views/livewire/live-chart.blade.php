<div wire:ignore class="bg-white p-10 rounded-lg shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px] w-full mb-8">
    <div class="text-2xl font-bold mb-2 capitalize">Pemilihan {{ $jenis_pemilihan }}</div>
    <div>
        <canvas id="myChart_{{ $jenis_pemilihan }}" class="w-full h-96"></canvas>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                // Interval untuk polling event ke server, 3 detik.
                setInterval(() => @this.dispatch('ubahData'), 3000);
            });

            // Inisialisasi chart awal
            let chartData_{{ $jenis_pemilihan }} = JSON.parse(@json($chartDataJson));
            const ctx_{{ $jenis_pemilihan }} = document.getElementById('myChart_{{ $jenis_pemilihan }}').getContext('2d');
            
            const data_{{ $jenis_pemilihan }} = {
                labels: chartData_{{ $jenis_pemilihan }}.labels,
                datasets: [{
                    label: `Total Suara Masuk: ${chartData_{{ $jenis_pemilihan }}.total}`,
                    data: chartData_{{ $jenis_pemilihan }}.data,
                    backgroundColor: chartData_{{ $jenis_pemilihan }}.colors,
                    borderColor: chartData_{{ $jenis_pemilihan }}.borderColors,
                    borderWidth: 2,
                    hoverBackgroundColor: chartData_{{ $jenis_pemilihan }}.colors.map(c => c.replace('0.8)', '1)')),
                }]
            };

            const config_{{ $jenis_pemilihan }} = {
                type: 'bar',
                data: data_{{ $jenis_pemilihan }},
                options: {
                    layout: {
                        padding: {
                            top: 100 // Berikan ruang kosong di atas chart untuk gambar foto
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: chartData_{{ $jenis_pemilihan }}.total < 10 ? 10 : undefined,
                            ticks: {
                                stepSize: 1, // Agar jika angkanya kecil, step nya 1 (1, 2, 3...)
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
                    beforeDraw: function(chart) {
                        const ctx = chart.ctx;
                        const images = chartData_{{ $jenis_pemilihan }}.images;
                        
                        images.forEach((src, index) => {
                            if (!src) return;
                            const image = new Image();
                            image.src = src;
                            
                            image.onload = function() {
                                try {
                                    const meta = chart.getDatasetMeta(0);
                                    meta.data.forEach((bar, barIndex) => {
                                        if (barIndex === index) {
                                            const x = bar.x;
                                            const y = bar.y - 80;
                                            
                                            if (!isNaN(x) && !isNaN(y) && chart.height > y) {
                                                ctx.drawImage(image, x - 45, y, 90, 90);
                                            }
                                        }
                                    });
                                } catch (e) {}
                            };
                        });
                    }
                }]
            };

            const myChartIns_{{ $jenis_pemilihan }} = new Chart(ctx_{{ $jenis_pemilihan }}, config_{{ $jenis_pemilihan }});

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('berhasilUpdate-{{ $jenis_pemilihan }}', (event) => {
                    // Extract payload efficiently for Livewire v3 variants
                    let payload = Array.isArray(event) ? event[0] : event;
                    let targetData = payload.data ? payload.data : payload;
                    
                    let updatedData = typeof targetData === 'string' ? JSON.parse(targetData) : targetData;
                    
                    // Update variables local
                    chartData_{{ $jenis_pemilihan }} = updatedData;
                    
                    // Force update labels and logic manually to ensure integrity
                    myChartIns_{{ $jenis_pemilihan }}.data.labels = updatedData.labels;
                    myChartIns_{{ $jenis_pemilihan }}.data.datasets[0].data = updatedData.data;
                    myChartIns_{{ $jenis_pemilihan }}.data.datasets[0].backgroundColor = updatedData.colors;
                    myChartIns_{{ $jenis_pemilihan }}.data.datasets[0].borderColor = updatedData.borderColors;
                    myChartIns_{{ $jenis_pemilihan }}.data.datasets[0].label = `Total Suara Masuk: ${updatedData.total}`;
                    myChartIns_{{ $jenis_pemilihan }}.update();
                });
            });
        </script>
    @endpush
</div>
