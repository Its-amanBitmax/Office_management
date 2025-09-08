@extends('layouts.admin')

@section('page-title', 'Employee Performance')
@section('page-description', 'View employee performance metrics and ratings')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Performance Overview</h4>
            <div class="btn-group" role="group" aria-label="Period selection">
                @foreach(['daily', 'weekly', 'monthly'] as $p)
                    <a href="{{ route('admin.performance', array_merge(['period' => $p], request()->only(['employee_id']))) }}"
                       class="btn btn-outline-primary {{ $period == $p ? 'active' : '' }}">
                        {{ ucfirst($p) }}
                    </a>
                @endforeach
            </div>
        </div>
        <p class="text-muted">Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
    </div>
</div>

<div class="row mb-4 g-3">
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h5 class="card-title">Total Ratings</h5>
                <h2 class="text-primary">{{ $totalRatings }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h5 class="card-title">Average Rating</h5>
                <h2 class="text-success">{{ $averageRating }}</h2>
                <div class="star-rating" aria-label="Average star rating">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-warning' : 'text-muted' }}" aria-hidden="true"></i>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Rating Distribution</h5>
                <canvas id="ratingDistributionChart" width="400" height="200" aria-label="Rating distribution chart" role="img"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <form method="GET" action="{{ route('admin.performance') }}" aria-label="Filter by employee">
            <div class="input-group">
                <select name="employee_id" class="form-select" onchange="this.form.submit()" aria-label="Select employee to filter">
                    <option value="">-- All Employees --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }} ({{ $emp->employee_code }})
                        </option>
                    @endforeach
                </select>
                @if(request('employee_id'))
                    <a href="{{ route('admin.performance', ['period' => $period]) }}" class="btn btn-outline-secondary" aria-label="Clear employee filter">Clear Filter</a>
                @endif
                <noscript><button type="submit" class="btn btn-primary">Filter</button></noscript>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card" role="region" aria-label="Employee performance rankings chart">
            <div class="card-header">
                <h5>Employee Performance Rankings</h5>
            </div>
            <div class="card-body">
                <canvas id="employeePerformanceChart" width="800" height="400" aria-label="Employee performance bar chart" role="img"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card" role="region" aria-label="Detailed employee performance table">
            <div class="card-header">
                <h5>Detailed Employee Performance</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle" aria-describedby="Detailed employee performance including total reports, average rating, star rating, and rating breakdown">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Employee</th>
                                <th scope="col" class="text-center">Total Ratings</th>
                                <th scope="col" class="text-center">Average Rating</th>
                                <th scope="col" class="text-center">Star Rating</th>
                                <th scope="col" class="text-center">Total Stars</th>
                                {{-- <th scope="col">Rating Breakdown</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employeePerformance as $performance)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;" aria-hidden="true">
                                            {{ strtoupper(substr($performance['employee']->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $performance['employee']->name }}</div>
                                            <small class="text-muted">{{ $performance['employee']->employee_code }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $performance['total_ratings'] }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $performance['average_rating'] }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="star-rating" aria-label="Star rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= round($performance['average_rating']) ? 'text-warning' : 'text-muted' }}" aria-hidden="true"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="text-center">{{ $performance['total_stars'] }}</td>
                                {{-- <td>
                                    <div class="rating-breakdown">
                                        @for($i = 5; $i >= 1; $i--)
                                            <small class="text-muted">{{ $i }}★: {{ $performance['rating_counts'][$i] }}</small>
                                            @if($i > 1)<br>@endif
                                        @endfor
                                    </div>
                                    <small class="text-info">Combined rating from admin & team lead</small>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No performance data available for this period.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rating Distribution Chart
    const ratingCtx = document.getElementById('ratingDistributionChart').getContext('2d');
    const ratingData = @json($ratingDistribution);

    new Chart(ratingCtx, {
        type: 'doughnut',
        data: {
            labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
            datasets: [{
                data: Object.values(ratingData),
                backgroundColor: [
                    '#dc3545',
                    '#fd7e14',
                    '#ffc107',
                    '#20c997',
                    '#28a745'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Employee Performance Chart
    const employeeCtx = document.getElementById('employeePerformanceChart').getContext('2d');
    const employeeData = @json($employeePerformance);

    const employeeNames = employeeData.map(emp => emp.employee.name);
    const averageRatings = employeeData.map(emp => emp.average_rating);
    const totalRatings = employeeData.map(emp => emp.total_ratings);

    new Chart(employeeCtx, {
        type: 'bar',
        data: {
            labels: employeeNames,
            datasets: [{
                label: 'Average Rating',
                data: averageRatings,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Total Ratings',
                data: totalRatings,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Average Rating'
                    },
                    min: 0,
                    max: 5
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Total Ratings'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            },
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    });
});
</script>

<style>
.star-rating {
    font-size: 1.2rem;
}

.rating-breakdown small {
    display: block;
    line-height: 1.2;
}

.avatar-circle {
    font-size: 1rem;
}
</style>
@endsection
