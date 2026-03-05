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
                            bottom: 100 // Berikan ruang kosong di bawah chart untuk gambar foto
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
                                    size: 20,
                                    weight: '900',
                                },
                                color: '#111',
                                padding: 75 // Beri jarak antara teks angka (01, 02) dan garis bawah chart
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
                    id: 'customImages',
                    afterDraw: function(chart) {
                        const ctx = chart.ctx;
                        const images = chartData_{{ $jenis_pemilihan }}.images;
                        const chartArea = chart.chartArea;
                        
                        // Buat cache lokal agar gambar tidak diload ulang terus-menerus yang menyebabkan hilang timbul
                        if (!chart.imageMapCache) {
                            chart.imageMapCache = {};
                        }

                        images.forEach((pair, index) => {
                            if (!pair || !pair.ketua || !pair.wakil) return;
                            
                            const drawPair = (img1, img2) => {
                                try {
                                    const meta = chart.getDatasetMeta(0);
                                    if (!meta.data[index]) return;
                                    
                                    const bar = meta.data[index];
                                    const x = bar.x;
                                    
                                    // Letakkan di bawah label X-axis (angka 01, 02)
                                    const y = chartArea.bottom + 45; 
                                    
                                    const imgWidth = 50;  // Diperbesar sesuai desain
                                    const imgHeight = 65;
                                    const spacing = 0;    // Digabung rapat
                                    
                                    if (!isNaN(x) && !isNaN(y)) {
                                        ctx.save();
                                        
                                        const boxWidth = (imgWidth * 2) + spacing;
                                        const boxX = x - (boxWidth / 2);
                                        const boxY = y;
                                        
                                        // Draw Ketua (kiri)
                                        ctx.drawImage(img1, boxX, boxY, imgWidth, imgHeight);
                                        // Draw Wakil (kanan)
                                        ctx.drawImage(img2, boxX + imgWidth + spacing, boxY, imgWidth, imgHeight);
                                        
                                        // Berikan border kotak ala surat suara
                                        ctx.strokeStyle = '#333';
                                        ctx.lineWidth = 3;
                                        ctx.strokeRect(boxX, boxY, boxWidth, imgHeight);
                                        
                                        ctx.restore();
                                    }
                                } catch (e) {
                                    console.error(e);
                                }
                            };

                            let key = index;
                            
                            // Jika gambar sudah ter-cache dan ter-load, langsung gambar
                            if (chart.imageMapCache[key] && chart.imageMapCache[key].isLoaded) {
                                drawPair(chart.imageMapCache[key].imgK, chart.imageMapCache[key].imgW);
                            } 
                            // Jika belum di-inisasi proses download gambarnya
                            else if (!chart.imageMapCache[key]) {
                                chart.imageMapCache[key] = { 
                                    isLoaded: false, 
                                    loadedCount: 0,
                                    imgK: new Image(), 
                                    imgW: new Image() 
                                };
                                
                                // Setup CORS agar gambar GCS bisa digambar di atas Canvas
                                chart.imageMapCache[key].imgK.crossOrigin = "anonymous";
                                chart.imageMapCache[key].imgW.crossOrigin = "anonymous";
                                
                                const checkLoaded = () => {
                                    chart.imageMapCache[key].loadedCount++;
                                    if (chart.imageMapCache[key].loadedCount === 2) {
                                        chart.imageMapCache[key].isLoaded = true;
                                        chart.update('none'); // Panggil gambar ulang halus pada frame berikutnya
                                    }
                                };
                                
                                chart.imageMapCache[key].imgK.onload = checkLoaded;
                                chart.imageMapCache[key].imgW.onload = checkLoaded;
                                
                                chart.imageMapCache[key].imgK.src = pair.ketua;
                                chart.imageMapCache[key].imgW.src = pair.wakil;
                            }
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
