<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'menu.php';
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Registrations Dashboard</h1>

        <!-- فلترة البيانات -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="problemFilter" class="form-control" placeholder="Filter by problem number">
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-success" onclick="exportFilteredToCSV('filtered_registrations.csv')">Export Filtered to CSV</button>
            </div>
        </div>

        <!-- عرض الجدول -->
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Team Name</th>
                    <th>Problem Number</th>
                    <th>Leader Name</th>
                    <th>Leader Email</th>
                    <th>Leader Phone</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="registrationsTable">
                <!-- سيتم تعبئة البيانات هنا -->
            </tbody>
        </table>

        <!-- الرسوم البيانية -->
        <div class="row mt-5">
            <div class="col-md-6">
                <h2>University Registrations</h2>
                <canvas id="universityChart"></canvas>
            </div>
            <div class="col-md-6">
                <h2>Problem Distribution</h2>
                <canvas id="problemChart"></canvas>
            </div>
        </div>
    </div>
<script>
    let originalData = []; // حفظ البيانات الأصلية

    // جلب البيانات وعرضها في الجدول
    fetch('/api.php')
        .then(response => response.json())
        .then(data => {
            originalData = data; // حفظ البيانات الأصلية عند التحميل لأول مرة
            filteredData = data; // البدء بعرض جميع البيانات
            updateTableAndCharts(filteredData);
        });

    // وظيفة لتحديث الجدول والرسوم البيانية
    function updateTableAndCharts(data) {
        const tableBody = document.getElementById('registrationsTable');
        let tableRows = '';

        data.forEach((registration, index) => {
            tableRows += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${registration.team_name}</td>
                    <td>${registration.problem_number}</td>
                    <td>${registration.leader_name}</td>
                    <td>${registration.leader_email}</td>
                    <td>${registration.leader_phone}</td>
                    <td>${registration.registration_date}</td>
                    <td><a href="view_team.php?id=${registration.id}" class="btn btn-info">View Details</a></td>
                </tr>
            `;
        });

        tableBody.innerHTML = tableRows;

        // تحديث الرسوم البيانية هنا
        // ...
    }

    // وظيفة الفلترة برقم المشكلة
    document.getElementById('problemFilter').addEventListener('input', function() {
        const filterValue = this.value.trim();

        if (filterValue === '') {
            // إذا كان الفلتر فارغًا، عرض البيانات الأصلية
            filteredData = originalData;
        } else {
            // فلترة البيانات بناءً على رقم المشكلة
            filteredData = originalData.filter(row => row.problem_number.toString().includes(filterValue));
        }

        updateTableAndCharts(filteredData);
    });

    // وظيفة تصدير البيانات المفلترة إلى CSV
    function exportFilteredToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#registrationsTable tr");
        
        for (let i = 0; i < rows.length; i++) {
            const row = [], cols = rows[i].querySelectorAll("td, th");
            
            for (let j = 0; cols && j < cols.length; j++) {
                row.push(cols[j].innerText);
            }
            
            csv.push(row.join(","));
        }

        const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        const downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
    }
</script>

    <script>
        let filteredData = []; // لحفظ البيانات التي تم تطبيق الفلتر عليها

        // جلب البيانات وعرضها في الجدول
        fetch('/api.php')
            .then(response => response.json())
            .then(data => {
                filteredData = data; // البدء بعرض جميع البيانات
                updateTableAndCharts(filteredData);
            });

        // وظيفة لتحديث الجدول والرسوم البيانية
        function updateTableAndCharts(data) {
            const tableBody = document.getElementById('registrationsTable');
            let tableRows = '';

            data.forEach((registration, index) => {
                tableRows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${registration.team_name}</td>
                        <td>${registration.problem_number}</td>
                        <td>${registration.leader_name}</td>
                        <td>${registration.leader_email}</td>
                        <td>${registration.leader_phone}</td>
                        <td>${registration.registration_date}</td>
                        <td><a href="view_team.php?id=${registration.id}" class="btn btn-info">View Details</a></td>
                    </tr>
                `;
            });

            tableBody.innerHTML = tableRows;

            // رسم بياني للجامعات المسجلة
            const universities = data.map(reg => reg.leader_university);
            const universityCount = universities.reduce((acc, university) => {
                acc[university] = (acc[university] || 0) + 1;
                return acc;
            }, {});

            const ctxBar = document.getElementById('universityChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: Object.keys(universityCount),
                    datasets: [{
                        label: 'Number of Teams',
                        data: Object.values(universityCount),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
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

            // رسم بياني دائري لنسبة التوزيع حسب رقم المشكلة
            const problemNumbers = data.map(reg => reg.problem_number);
            const problemCount = problemNumbers.reduce((acc, number) => {
                acc[number] = (acc[number] || 0) + 1;
                return acc;
            }, {});

            const ctxPie = document.getElementById('problemChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: Object.keys(problemCount),
                    datasets: [{
                        data: Object.values(problemCount),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    let total = Object.values(problemCount).reduce((a, b) => a + b, 0);
                                    let value = tooltipItem.raw;
                                    let percentage = ((value / total) * 100).toFixed(2);
                                    return `Problem ${tooltipItem.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // وظيفة الفلترة برقم المشكلة
        document.getElementById('problemFilter').addEventListener('input', function() {
            const filterValue = this.value;
            filteredData = filteredData.filter(row => row.problem_number.toString().includes(filterValue));
            updateTableAndCharts(filteredData);
        });

        // وظيفة تصدير البيانات المفلترة إلى CSV
        function exportFilteredToCSV(filename) {
            let csv = [];
            const rows = document.querySelectorAll("#registrationsTable tr");
            
            for (let i = 0; i < rows.length; i++) {
                const row = [], cols = rows[i].querySelectorAll("td, th");
                
                for (let j = 0; j < cols.length; j++) {
                    row.push(cols[j].innerText);
                }
                
                csv.push(row.join(","));
            }

            const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
            const downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
        }
    </script>
</body>
</html>
