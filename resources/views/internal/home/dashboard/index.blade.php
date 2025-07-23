@extends('layouts.base')

@section('title', 'Dashboard')

@section('content')
    <section>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 border-start border-0 border-primary rounded-2">
                        <div class="card-body d-flex align-items-center social-user">
                            <div class="me-4 text-primary">
                                <i class="ti ti-chalkboard"></i>
                            </div>
                            <div>
                                <div class="h4 fw-normal mb-0 count-up" data-target="{{ $totalTrainings }}">0</div>
                                <div class="text-primary">Pelatihan</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 border-start border-0 border-secondary rounded-2">
                        <div class="card-body d-flex align-items-center social-user">
                            <div class="me-4 text-secondary">
                                <i class="ti ti-users"></i>
                            </div>
                            <div>
                                <div class="h4 fw-normal mb-0 count-up" data-target="{{ $totalParticipants }}">0</div>
                                <div class="text-secondary">Peserta</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 border-start border-0 border-success rounded-2">
                        <div class="card-body d-flex align-items-center social-user">
                            <div class="me-4 text-success">
                                <i class="ti ti-video"></i>
                            </div>
                            <div>
                                <div class="h4 fw-normal mb-0 count-up" data-target="{{ $totalVideos }}">0</div>
                                <div class="text-success">Video</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 border-start border-0 border-warning rounded-2">
                        <div class="card-body d-flex align-items-center social-user">
                            <div class="me-4 text-warning">
                                <i class="ti ti-chalkboard"></i>
                            </div>
                            <div class="text-start">
                                <div class="h4 fw-normal mb-0 count-up" data-target="">0</div>
                                <div class="text-warning">Pendampingan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Grafik Pendaftaran Pelatihan -->
                <div class="col-lg-12 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4 fs-3">Statistik Pendaftaran Pelatihan</h5>
                            <div id="training-registration-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluasi Pelatihan & Instruktur di bawah -->
            <div class="row mb-2">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4 fs-3">Statistik Evaluasi Pelatihan</h5>
                            <div id="training-evaluation-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4 fs-3">Statistik Evaluasi Instruktur</h5>
                            <div id="instructor-evaluation-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4 fs-3">Statistik Pre-Test</h5>
                            <div id="pre-test-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4 fs-3">Statistik Post-Test</h5>
                            <div id="post-test-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll('.count-up');
            const speed = 200; // Semakin kecil, semakin cepat

            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;

                    const increment = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCount, 10);
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
            });
        });

        // Training Registration Chart
        var trainingRegistrationOptions = {
            series: [{
                name: 'Jumlah Pendaftar',
                data: {!! json_encode(
                    array_map(
                        function ($date, $total) {
                            return ['x' => $date, 'y' => $total];
                        },
                        $trainingRegistrationData['labels']->toArray(),
                        $trainingRegistrationData['data']->toArray(),
                    ),
                ) !!}
            }],
            chart: {
                type: 'area',
                height: 300,
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                }
            },
            grid: {
                show: false
            },
            colors: ['#559cf9'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0,
                    stops: [0, 100]
                }
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    format: 'dd MMM',
                }
            },
            tooltip: {
                x: {
                    format: 'dd MMM yyyy'
                },
                y: {
                    formatter: function(val) {
                        return val + ' pendaftar'
                    }
                }
            }
        };

        var trainingRegistrationChart = new ApexCharts(
            document.querySelector("#training-registration-chart"),
            trainingRegistrationOptions
        );
        trainingRegistrationChart.render();

        // Pre-Test Chart
        // Pre-Test Chart
        var preTestOptions = {
            series: [{
                name: 'Nilai Pre Test',
                data: {{ json_encode($preTestData['data']) }}
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: {
                    show: false
                }
            },
            colors: ['#3B82F6'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '30%',
                    borderRadius: 4
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: {{ json_encode($preTestData['labels']) }},
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Rata-rata Nilai'
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.4,
                    gradientToColors: ["#93C5FD"],
                    inverseColors: false,
                    opacityFrom: 0.85,
                    opacityTo: 0.3,
                    stops: [0, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        };

        var preTestChart = new ApexCharts(document.querySelector("#pre-test-chart"), preTestOptions);
        preTestChart.render();


        // Post-Test Chart
        var postTestOptions = {
            series: [{
                name: 'Nilai Post Test',
                data: {{ json_encode($postTestData['data']) }}
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: {
                    show: false
                }
            },
            colors: ['#3B82F6'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '30%',
                    borderRadius: 4
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: {{ json_encode($postTestData['labels']) }},
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Rata-rata Nilai',

                    
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.4,
                    gradientToColors: ["#93C5FD"],
                    inverseColors: false,
                    opacityFrom: 0.85,
                    opacityTo: 0.3,
                    stops: [0, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        };

        var postTestChart = new ApexCharts(document.querySelector("#post-test-chart"), postTestOptions);
        postTestChart.render();


        // Training Evaluation Chart
        var trainingEvaluationOptions = {
            series: {{ json_encode($trainingEvaluationData->values()) }},
            chart: {
                type: 'donut',
                height: 220
            },
            labels: {{ json_encode($trainingEvaluationData->keys()) }},
            plotOptions: {
                pie: {
                    donut: {
                        size: '60%'
                    }
                }
            },
            dataLabels: {
                style: {
                    fontSize: '10px'
                }
            },
            legend: {
                position: 'bottom',
                fontSize: '10px'
            },
            colors: ['#559cf9', '#6caefd', '#88c0ff', '#a3d2ff', '#cce5ff']
        };

        var trainingEvaluationChart = new ApexCharts(document.querySelector("#training-evaluation-chart"),
            trainingEvaluationOptions);
        trainingEvaluationChart.render();

        // Instructor Evaluation Chart
        var instructorEvaluationOptions = {
            series: {{ json_encode($instructorEvaluationData->values()) }},
            chart: {
                type: 'donut',
                height: 220
            },
            labels: {{ json_encode($instructorEvaluationData->keys()) }},
            plotOptions: {
                pie: {
                    donut: {
                        size: '60%'
                    }
                }
            },
            dataLabels: {
                style: {
                    fontSize: '10px'
                }
            },
            legend: {
                position: 'bottom',
                fontSize: '10px'
            },
            colors: ['#559cf9', '#6caefd', '#88c0ff', '#a3d2ff', '#cce5ff'],
        };
        var instructorEvaluationChart = new ApexCharts(document.querySelector("#instructor-evaluation-chart"),
            instructorEvaluationOptions);
        instructorEvaluationChart.render();
    </script>
@endpush
