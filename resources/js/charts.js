import ApexCharts from 'apexcharts';

// Custom color palette - Matte Tangerine Orange & Matte Blue
const MATTE_BLUE = '#3D5A80';
const MATTE_BLUE_LIGHT = '#5B7BA3';
const MATTE_BLUE_DARK = '#2C4563';
const TANGERINE = '#E07A3E';
const TANGERINE_LIGHT = '#E89A6A';
const TANGERINE_DARK = '#C6622A';

// Color arrays for charts
const BLUE_PALETTE = [MATTE_BLUE, MATTE_BLUE_LIGHT, '#7A9CC6', '#98B4D4', '#B6CCE3'];
const ORANGE_PALETTE = [TANGERINE, TANGERINE_LIGHT, '#F0B896', '#F5CDB8', '#FAE2DA'];
const MIXED_PALETTE = [MATTE_BLUE, TANGERINE, MATTE_BLUE_LIGHT, TANGERINE_LIGHT, '#7A9CC6', '#F0B896'];

// Dark theme chart options
const darkThemeOptions = {
    chart: {
        background: 'transparent',
        foreColor: '#e4e4e7',
        toolbar: {
            show: true,
            tools: {
                download: true,
                selection: false,
                zoom: false,
                zoomin: false,
                zoomout: false,
                pan: false,
                reset: false
            }
        }
    },
    theme: {
        mode: 'dark'
    },
    grid: {
        borderColor: '#374151',
        strokeDashArray: 4
    },
    tooltip: {
        theme: 'dark',
        style: {
            fontSize: '12px'
        }
    },
    legend: {
        labels: {
            colors: '#e4e4e7'
        }
    },
    xaxis: {
        labels: {
            style: {
                colors: '#9ca3af'
            }
        },
        axisBorder: {
            color: '#374151'
        },
        axisTicks: {
            color: '#374151'
        }
    },
    yaxis: {
        labels: {
            style: {
                colors: '#9ca3af'
            }
        }
    }
};

// Initialize all charts on dashboard
export async function initDashboardCharts() {
    try {
        // Fetch all stats data
        const [barangayData, genderData, ageGroupData, categoryData] = await Promise.all([
            fetch('/api/stats/barangay').then(r => r.json()),
            fetch('/api/stats/gender').then(r => r.json()),
            fetch('/api/stats/age-group').then(r => r.json()),
            fetch('/api/stats/category').then(r => r.json()),
        ]);

        // Barangay Distribution Chart (Horizontal Bar)
        const barangayChartEl = document.getElementById('barangayChart');
        if (barangayChartEl) {
            const barangayChart = new ApexCharts(barangayChartEl, {
                ...darkThemeOptions,
                series: [{
                    name: 'Fisherfolk',
                    data: barangayData.data.map(d => d.count)
                }],
                chart: {
                    ...darkThemeOptions.chart,
                    type: 'bar',
                    height: 380
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        barHeight: '70%',
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                colors: BLUE_PALETTE,
                dataLabels: {
                    enabled: true,
                    textAnchor: 'start',
                    style: {
                        colors: ['#e4e4e7'],
                        fontSize: '12px',
                        fontWeight: 600
                    },
                    formatter: function(val) {
                        return val;
                    },
                    offsetX: 5
                },
                xaxis: {
                    ...darkThemeOptions.xaxis,
                    categories: barangayData.data.map(d => d.barangay),
                    labels: {
                        style: {
                            colors: '#9ca3af',
                            fontSize: '11px'
                        }
                    }
                },
                yaxis: {
                    ...darkThemeOptions.yaxis,
                    labels: {
                        style: {
                            colors: '#9ca3af',
                            fontSize: '11px'
                        }
                    }
                },
                title: {
                    text: 'Fisherfolk by Barangay',
                    align: 'left',
                    style: {
                        fontSize: '16px',
                        fontWeight: 600,
                        color: '#e4e4e7'
                    }
                },
                legend: {
                    show: false
                }
            });
            barangayChart.render();
        }

        // Gender Distribution Chart (Donut)
        const genderChartEl = document.getElementById('genderChart');
        if (genderChartEl) {
            const genderChart = new ApexCharts(genderChartEl, {
                ...darkThemeOptions,
                series: genderData.data.map(d => d.count),
                chart: {
                    ...darkThemeOptions.chart,
                    type: 'donut',
                    height: 380
                },
                labels: genderData.data.map(d => d.gender),
                colors: [MATTE_BLUE, TANGERINE],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '16px',
                                    color: '#e4e4e7'
                                },
                                value: {
                                    show: true,
                                    fontSize: '28px',
                                    fontWeight: 700,
                                    color: '#e4e4e7'
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    fontSize: '14px',
                                    color: '#9ca3af',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                title: {
                    text: 'Gender Distribution',
                    align: 'left',
                    style: {
                        fontSize: '16px',
                        fontWeight: 600,
                        color: '#e4e4e7'
                    }
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    labels: {
                        colors: '#e4e4e7'
                    },
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 12
                    }
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['#1a1a2e']
                }
            });
            genderChart.render();
        }

        // Age Group Distribution Chart (Column)
        const ageGroupChartEl = document.getElementById('ageGroupChart');
        if (ageGroupChartEl) {
            const ageGroupChart = new ApexCharts(ageGroupChartEl, {
                ...darkThemeOptions,
                series: [{
                    name: 'Count',
                    data: ageGroupData.data.map(d => d.count)
                }],
                chart: {
                    ...darkThemeOptions.chart,
                    type: 'bar',
                    height: 380
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '60%',
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                colors: [MATTE_BLUE, MATTE_BLUE_LIGHT, TANGERINE, TANGERINE_LIGHT, '#7A9CC6'],
                dataLabels: {
                    enabled: true,
                    style: {
                        colors: ['#e4e4e7'],
                        fontSize: '12px',
                        fontWeight: 600
                    },
                    offsetY: -20
                },
                xaxis: {
                    ...darkThemeOptions.xaxis,
                    categories: ageGroupData.data.map(d => d.age_group),
                    labels: {
                        style: {
                            colors: '#9ca3af',
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    ...darkThemeOptions.yaxis,
                    labels: {
                        style: {
                            colors: '#9ca3af'
                        },
                        formatter: function(val) {
                            return Math.round(val);
                        }
                    }
                },
                title: {
                    text: 'Age Group Distribution',
                    align: 'left',
                    style: {
                        fontSize: '16px',
                        fontWeight: 600,
                        color: '#e4e4e7'
                    }
                },
                legend: {
                    show: false
                }
            });
            ageGroupChart.render();
        }

        // Activity Categories Chart (Radial Bar)
        const categoryChartEl = document.getElementById('categoryChart');
        if (categoryChartEl) {
            const maxCount = Math.max(...categoryData.data.map(d => d.count));
            const percentages = categoryData.data.map(d => Math.round((d.count / maxCount) * 100));
            
            const categoryChart = new ApexCharts(categoryChartEl, {
                ...darkThemeOptions,
                series: percentages,
                chart: {
                    ...darkThemeOptions.chart,
                    type: 'radialBar',
                    height: 380
                },
                plotOptions: {
                    radialBar: {
                        offsetY: 0,
                        startAngle: 0,
                        endAngle: 270,
                        hollow: {
                            margin: 5,
                            size: '30%',
                            background: 'transparent'
                        },
                        track: {
                            background: '#374151',
                            strokeWidth: '100%',
                            margin: 5
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                fontSize: '14px',
                                color: '#e4e4e7'
                            },
                            value: {
                                show: true,
                                fontSize: '16px',
                                color: '#e4e4e7',
                                formatter: function(val, opts) {
                                    return categoryData.data[opts.seriesIndex]?.count || val;
                                }
                            },
                            total: {
                                show: true,
                                label: 'Total Activities',
                                fontSize: '12px',
                                color: '#9ca3af',
                                formatter: function() {
                                    return categoryData.data.reduce((a, b) => a + b.count, 0);
                                }
                            }
                        }
                    }
                },
                colors: [TANGERINE, MATTE_BLUE, TANGERINE_LIGHT, MATTE_BLUE_LIGHT, '#F0B896', '#7A9CC6'],
                labels: categoryData.data.map(d => d.category),
                title: {
                    text: 'Activity Categories',
                    align: 'left',
                    style: {
                        fontSize: '16px',
                        fontWeight: 600,
                        color: '#e4e4e7'
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    floating: false,
                    fontSize: '12px',
                    labels: {
                        colors: '#e4e4e7'
                    },
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 12
                    }
                },
                stroke: {
                    lineCap: 'round'
                }
            });
            categoryChart.render();
        }

    } catch (error) {
        console.error('Error initializing charts:', error);
    }
}
