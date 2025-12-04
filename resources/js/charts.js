import Chart from 'chart.js/auto';

// Maritime color scheme
const PRIMARY_COLOR = 'rgb(0, 0, 255)';
const SECONDARY_COLOR = 'rgb(255, 165, 0)';
const OCEAN_BLUE = 'rgb(0, 102, 204)';
const SUNSET_ORANGE = 'rgb(255, 140, 0)';

// Chart color palettes
const BLUE_GRADIENT = [
    'rgba(0, 0, 255, 0.8)',
    'rgba(0, 102, 204, 0.8)',
    'rgba(0, 153, 255, 0.8)',
    'rgba(51, 153, 255, 0.8)',
    'rgba(102, 178, 255, 0.8)',
];

const ORANGE_GRADIENT = [
    'rgba(255, 165, 0, 0.8)',
    'rgba(255, 140, 0, 0.8)',
    'rgba(255, 185, 51, 0.8)',
    'rgba(255, 204, 102, 0.8)',
    'rgba(255, 223, 153, 0.8)',
];

const MIXED_PALETTE = [
    'rgba(0, 0, 255, 0.8)',       // Blue
    'rgba(255, 165, 0, 0.8)',     // Orange
    'rgba(0, 102, 204, 0.8)',     // Ocean Blue
    'rgba(255, 140, 0, 0.8)',     // Sunset Orange
    'rgba(0, 153, 255, 0.8)',     // Light Blue
    'rgba(255, 204, 102, 0.8)',   // Light Orange
];

// Initialize all charts on dashboard
export async function initDashboardCharts() {
    try {
        // Fetch all stats data
        const [summaryData, barangayData, genderData, ageGroupData, categoryData] = await Promise.all([
            fetch('/api/stats/summary').then(r => r.json()),
            fetch('/api/stats/barangay').then(r => r.json()),
            fetch('/api/stats/gender').then(r => r.json()),
            fetch('/api/stats/age-group').then(r => r.json()),
            fetch('/api/stats/category').then(r => r.json()),
        ]);

        // Barangay Distribution Chart (Horizontal Bar)
        if (document.getElementById('barangayChart')) {
            new Chart(document.getElementById('barangayChart'), {
                type: 'bar',
                data: {
                    labels: barangayData.data.map(d => d.barangay),
                    datasets: [{
                        label: 'Fisherfolk Count',
                        data: barangayData.data.map(d => d.count),
                        backgroundColor: BLUE_GRADIENT,
                        borderColor: PRIMARY_COLOR,
                        borderWidth: 1,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Fisherfolk Distribution by Barangay',
                            font: { size: 16, weight: 'bold' }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        }

        // Gender Distribution Chart (Doughnut)
        if (document.getElementById('genderChart')) {
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: genderData.data.map(d => d.gender),
                    datasets: [{
                        data: genderData.data.map(d => d.count),
                        backgroundColor: [PRIMARY_COLOR, SECONDARY_COLOR],
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Gender Distribution',
                            font: { size: 16, weight: 'bold' }
                        }
                    }
                }
            });
        }

        // Age Group Distribution Chart (Bar)
        if (document.getElementById('ageGroupChart')) {
            new Chart(document.getElementById('ageGroupChart'), {
                type: 'bar',
                data: {
                    labels: ageGroupData.data.map(d => d.age_group),
                    datasets: [{
                        label: 'Count',
                        data: ageGroupData.data.map(d => d.count),
                        backgroundColor: OCEAN_BLUE,
                        borderColor: PRIMARY_COLOR,
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Age Group Distribution',
                            font: { size: 16, weight: 'bold' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        }

        // Activity Categories Chart (Horizontal Bar)
        if (document.getElementById('categoryChart')) {
            new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: categoryData.data.map(d => d.category),
                    datasets: [{
                        label: 'Count',
                        data: categoryData.data.map(d => d.count),
                        backgroundColor: ORANGE_GRADIENT,
                        borderColor: SECONDARY_COLOR,
                        borderWidth: 1,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Activity Categories',
                            font: { size: 16, weight: 'bold' }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        }

    } catch (error) {
        console.error('Error initializing charts:', error);
    }
}

// Auto-initialize charts when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDashboardCharts);
} else {
    initDashboardCharts();
}
