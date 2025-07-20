@extends('admin.layouts.app')

@section('title', 'Holiday Calendar')

@push('styles')
<style>
    /* Modern Professional Calendar Styling */
    .holiday-calendar {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eaeaea;
    }

    /* Header Styling */
    .fc-header-toolbar {
        background: #ffffff;
        color: #333;
        padding: 16px 20px;
        margin: 0;
        border-bottom: 1px solid #eaeaea;
    }

    .fc-toolbar-title {
        font-weight: 600;
        font-size: 1.25rem;
        color: #2c3e50;
    }

    /* Button Styling */
    .fc-button {
        background: #f8f9fa !important;
        color: #2c3e50 !important;
        border: 1px solid #eaeaea !important;
        border-radius: 6px !important;
        padding: 6px 12px !important;
        font-weight: 500 !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease !important;
    }

    .fc-button:hover {
        background: #e9ecef !important;
        transform: none !important;
        box-shadow: none !important;
    }

    .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #2c3e50 !important;
        color: white !important;
    }

    /* Day Cell Styling */
    .fc-daygrid-day {
        border: 1px solid #f5f5f5 !important;
    }

    .fc-daygrid-day:hover {
        background: #f8f9fa !important;
    }

    .fc-daygrid-day-number {
        padding: 4px 6px !important;
        font-size: 0.875rem;
    }

    /* Holiday Styling */
    .fc-daygrid-day.holiday {
        background-color: rgba(233, 30, 99, 0.05) !important;
        position: relative;
    }

    .fc-daygrid-day.holiday::after {
        content: '';
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 8px;
        height: 8px;
        background-color: #e91e63;
        border-radius: 50%;
    }

    /* Today Highlight */
    .fc-daygrid-day.fc-day-today {
        background-color: rgba(33, 150, 243, 0.05) !important;
    }

    .fc-day-today .fc-daygrid-day-number {
        color: #2196f3;
        font-weight: 600;
    }

    /* Weekend Styling */
    .fc-day-sat, .fc-day-sun {
        background-color: #fafafa !important;
    }

    /* Loading Animation */
    .calendar-loader {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
    }

    .spinner {
        width: 24px;
        height: 24px;
        border: 3px solid rgba(44, 62, 80, 0.1);
        border-top: 3px solid #2c3e50;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Legend Styling */
    .legend-container {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 12px 16px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .legend-color {
        width: 14px;
        height: 14px;
        border-radius: 3px;
        margin-right: 10px;
    }

    .holiday-color {
        background-color: rgba(233, 30, 99, 0.1);
        border: 1px solid rgba(233, 30, 99, 0.3);
    }

    .weekend-color {
        background-color: #fafafa;
        border: 1px solid #eaeaea;
    }

    .today-color {
        background-color: rgba(33, 150, 243, 0.1);
        border: 1px solid rgba(33, 150, 243, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Holiday Calendar</h2>
            <p class="text-muted small mb-0">Manage your  holidays</p>
        </div>
        <div class="d-flex">
            <button id="print-calendar" class="btn btn-sm btn-outline-secondary me-2">
                <i class="fas fa-print fa-sm me-1"></i> Print
            </button>
            <button id="export-calendar" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download fa-sm me-1"></i> Export
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0 position-relative">
            <div id="calendar-loader" class="calendar-loader">
                <div class="spinner"></div>
            </div>
            <div id="calendar" class="holiday-calendar"></div>
        </div>
    </div>

    <div class="mt-4 legend-container">
        <h6 class="mb-3 text-uppercase text-muted small fw-bold">Legend</h6>
        <div class="legend-item">
            <div class="legend-color holiday-color"></div>
            <span class="small">Public Holiday</span>
        </div>
        <div class="legend-item">
            <div class="legend-color weekend-color"></div>
            <span class="small">Weekend</span>
        </div>
        <div class="legend-item">
            <div class="legend-color today-color"></div>
            <span class="small">Today</span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize calendar
        const calendarEl = document.getElementById('calendar');
        const loader = document.getElementById('calendar-loader');
        let holidays = @json($holidays);
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'title',
                center: '',
                right: 'prev,next today dayGridMonth,dayGridWeek,dayGridDay'
            },
            firstDay: 1, // Monday as first day
            height: 'auto',
            aspectRatio: 1.8,
            dayMaxEventRows: true,
            navLinks: true,
            editable: true,
            dayCellClassNames: function(arg) {
                if (holidays.includes(arg.date.toISOString().split('T')[0])) {
                    return ['holiday'];
                }
                return [];
            },
            dateClick: function(info) {
                toggleHolidayStatus(info.dateStr);
            },
            loading: function(isLoading) {
                if (isLoading) {
                    loader.style.display = 'block';
                } else {
                    loader.style.display = 'none';
                }
            },
            eventDidMount: function(info) {
                // Additional styling if needed
            }
        });

        calendar.render();

        // Print button functionality
        document.getElementById('print-calendar').addEventListener('click', function() {
            window.print();
        });

        // Export button functionality (placeholder)
        document.getElementById('export-calendar').addEventListener('click', function() {
            toastr.info('Export functionality will be implemented soon');
        });

        // Toggle holiday status
        function toggleHolidayStatus(date) {
            loader.style.display = 'block';
            
            fetch('{{ route("holidays.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ date: date })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'added') {
                    holidays.push(date);
                    toastr.success('Date marked as holiday');
                } else if (data.status === 'removed') {
                    holidays = holidays.filter(d => d !== date);
                    toastr.success('Holiday removed');
                }
                
                // Refresh calendar view
                calendar.refetchEvents();
                
                // Manually add/remove holiday class
                const dayEl = document.querySelector(`.fc-day[data-date="${date}"]`);
                if (dayEl) {
                    if (data.status === 'added') {
                        dayEl.classList.add('holiday');
                    } else {
                        dayEl.classList.remove('holiday');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('An error occurred. Please try again.');
            })
            .finally(() => {
                loader.style.display = 'none';
            });
        }
    });
</script>
@endpush