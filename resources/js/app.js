import './bootstrap';

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';
import _ from 'lodash';
import { initDashboardCharts } from './charts';
import 'flyonui/flyonui';

// Make ApexCharts and lodash available globally
window.ApexCharts = ApexCharts;
window._ = _;

window.Alpine = Alpine;

Alpine.start();

// Initialize charts if on dashboard page (when canvas elements exist)
window.initDashboardCharts = initDashboardCharts;

// Auto-initialize charts when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('barangayChart')) {
        initDashboardCharts();
    }
});
