@extends('layouts.master')

@section('title', 'Dashboard - Relatórios de Oficinas')

@section('content_header')
    <h1>Dashboard de Relatórios de Oficinas</h1>
@stop

@section('content')
<x-app-layout>
    <!-- Cards Resumo -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $summaryCards['total_reports'] }}</h3>
                    <p>Total de Relatórios</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $summaryCards['total_instructors'] }}</h3>
                    <p>Instrutores Ativos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $summaryCards['reports_this_month'] }}</h3>
                    <p>Relatórios Este Mês</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $summaryCards['total_workshops'] }}</h3>
                    <p>Oficinas Únicas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Linha - Oficinas por Mês -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Relatórios e Oficinas nos Últimos 6 Meses</h3>
                </div>
                <div class="card-body">
                    <canvas id="workshopsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos de Pizza lado a lado -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribuição de Feedbacks</h3>
                </div>
                <div class="card-body">
                    <canvas id="feedbackChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Atividades Extras</h3>
                </div>
                <div class="card-body">
                    <canvas id="activitiesChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Materiais Fornecidos</h3>
                </div>
                <div class="card-body">
                    <canvas id="materialsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela Top Instrutores -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top 5 Instrutores</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Instrutor</th>
                                <th>Relatórios</th>
                                <th>Oficinas Únicas</th>
                                <th>Média por Relatório</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topInstructors as $index => $instructor)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $instructor->name }}</td>
                                <td><span class="badge bg-primary">{{ $instructor->total_reports }}</span></td>
                                <td><span class="badge bg-success">{{ $instructor->total_workshops }}</span></td>
                                <td>
                                    @php
                                        $avg = $instructor->total_reports > 0 
                                            ? round($instructor->total_workshops / $instructor->total_reports, 2)
                                            : 0;
                                    @endphp
                                    <span class="badge bg-info">{{ $avg }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@stop

@section('css')
    <style>
        .small-box .icon {
            font-size: 70px;
        }
        canvas {
            max-height: 300px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Gráfico de Linha - Oficinas por Mês
            new Chart(document.getElementById('workshopsChart'), {
                type: 'line',
                data: {
                    labels: @json($workshopsByMonth['labels']),
                    datasets: [{
                        label: 'Relatórios',
                        data: @json($workshopsByMonth['reports']),
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3,
                        fill: true
                    }, {
                        label: 'Oficinas Únicas',
                        data: @json($workshopsByMonth['workshops']),
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Gráfico de Pizza - Feedbacks
            new Chart(document.getElementById('feedbackChart'), {
                type: 'pie',
                data: {
                    labels: @json($feedbackData['labels']),
                    datasets: [{
                        data: @json($feedbackData['data']),
                        backgroundColor: @json($feedbackData['colors'])
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Gráfico de Pizza - Atividades Extras
            new Chart(document.getElementById('activitiesChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($extraActivitiesData['labels']),
                    datasets: [{
                        data: @json($extraActivitiesData['data']),
                        backgroundColor: @json($extraActivitiesData['colors'])
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Gráfico de Pizza - Materiais
            new Chart(document.getElementById('materialsChart'), {
                type: 'pie',
                data: {
                    labels: @json($materialsData['labels']),
                    datasets: [{
                        data: @json($materialsData['data']),
                        backgroundColor: @json($materialsData['colors'])
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@stop