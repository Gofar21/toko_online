@extends('admin.layout.app')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard </h3>
                <a href="{{ route('admin.exportPdf') }}" class="btn btn-danger">Export to PDF</a>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{ asset('adminassets') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Pendapatan <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Rp. {{ number_format($pendapatan->penghasilan,2,',','.') }}</h2>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{ asset('adminassets') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Transaksi <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{ $transaksi->total_order }}</h2>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{ asset('adminassets') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Pelanggan <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{ $pelanggan->total_user }}</h2>
                  </div>
                </div>
              </div>
            </div>
            <div class="container mt-5">
              <h2>Pertanyaan Terbanyak Sebulan</h2>
              <div class="row">
                <div class="tgl_mulai ml-3">
                  <label>Tanggal Mulai</label>
                  <input type="date" id="tgl_mulai">
                </div>
                <div class="tgl_akhir ml-8">
                  <label>Tanggal Akhir</label>
                  <input type="date" id="tgl_akhir">
                </div>
                <button type="button" class="btn bg-blue-500 ml-3" id="filter-button">Filter</button>
              </div>
              <canvas id="questionsChart"></canvas>
            </div>
            <div class="container mt-5">
              <h2>Data Persentase</h2>
              <canvas id="percentageChart"></canvas>
          </div>
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">10 Transaksi Terbaru</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Invoice </th>
                            <th> Pemesan </th>
                            <th> Subtotal </th>
                            <th> Status Pesanan </th>
                            <th> Aksi </th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($order_baru as $order)
                            <tr>
                              <td>{{ $order->invoice }}</td>
                              <td>{{ $order->nama_pemesan }}</td>
                              <td>{{ $order->subtotal + $order->biaya_cod }}</td>
                              <td>{{ $order->name }}</td>
                              <td> <a href="{{ route('admin.transaksi.detail',['id'=>$order->id]) }}" class="btn btn-warning btn-sm">Detail</a></td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          <script>
            document.addEventListener("DOMContentLoaded", function() {
                var ctx = document.getElementById('questionsChart').getContext('2d');
                var questionsCount = @json($questionsCount);
                
                var questions = [];
                var counts = [];
                
                questionsCount.forEach(function(record) {
                    questions.push(record.text_input);
                    counts.push(record.count);
                });
            
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: questions,
                        datasets: [{
                            label: 'Jumlah Pertanyaan',
                            data: counts,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
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
            
                document.getElementById('filter-button').addEventListener('click', function() {
                    var startDate = document.getElementById('tgl_mulai').value;
                    var endDate = document.getElementById('tgl_akhir').value;
            
                    fetch("{{ route('admin.filterQuestions') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            start_date: startDate,
                            end_date: endDate
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        var newQuestions = [];
                        var newCounts = [];
            
                        data.forEach(function(record) {
                            newQuestions.push(record.text_input);
                            newCounts.push(record.count);
                        });
            
                        chart.data.labels = newQuestions;
                        chart.data.datasets[0].data = newCounts;
                        chart.update();
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
            
            document.addEventListener("DOMContentLoaded", function() {
                var ctxPie = document.getElementById('percentageChart').getContext('2d');
                var percentageData = @json($percentageData);
            
                var labels = [];
                var percentages = [];
                
                percentageData.forEach(function(record) {
                    labels.push(record.text_input);
                    percentages.push(record.percentage);
                });
            
                var pieChart = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Persentase',
                            data: percentages,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(255, 159, 64, 0.8)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        var label = pieChart.data.labels[tooltipItem.index];
                                        var value = pieChart.data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                        return label + ': ' + value.toFixed(2) + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            });
            </script>
            
@endsection