
<?php
include('include/session_check.php');
checkRole('scale_company');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Task Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2d3436;
            color: #fff;
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar a {
            text-decoration: none;
            color: #dfe6e9;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 5px 0;
            display: block;
            font-size: 16px;
        }
        .sidebar a:hover {
            background-color: #636e72;
        }
        .sidebar a.active {
            background-color: #0984e3;
        }
        .container {
            margin-left: 270px;
            width: calc(100% - 270px);
            padding: 20px;
            margin-top: 80px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .task-summary {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .summary-card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            color: #fff;
            font-weight: bold;
        }
        .summary-card.pending {
            background-color: #ff6b6b;
        }
        .summary-card.in-progress {
            background-color: #feca57;
        }
        .summary-card.completed {
            background-color: #1dd1a1;
        }
        .task-list {
            margin-top: 20px;
            padding: 35px;
        }
        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            background: #f9f9f9;
        }
        .task-item.pending {
            border-left: 5px solid #ff6b6b;
        }
        .task-item.in-progress {
            border-left: 5px solid #feca57;
        }
        .task-item.completed {
            border-left: 5px solid #1dd1a1;
        }
        .task-item .task-details {
            flex: 1;
        }
        .task-item .task-details p {
            margin: 5px 0;
        }
        .task-item .task-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background-color: #1dd1a1;
            color: #fff;
            cursor: pointer;
        }
        .task-item .task-actions button:hover {
            background-color: #10ac84;
        }
        .chart-container {
            max-width: 600px;
            margin: 0 auto;
        }


        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 10px;
                text-align: center;
            }
            .sidebar a {
                display: inline-block;
                padding: 10px;
            }
            .container {
                margin-left: 0;
                width: 100%;
                padding: 10px;
                margin-top: 20px;
            }
            .task-item {
                flex-direction: column;
                text-align: center;
            }
            .task-actions button {
                width: 100%;
                margin-top: 10px;
            }
            .task-summary {
                flex-direction: column;
                align-items: center;
            }
        }

    </style>
</head>
<body>
    <?php
    include('include/header.php');
    ?>

    <div class="sidebar">
        <h2>Navigation</h2>
        <a href="#" class="active" onclick="filterTasks('all')">All Tasks</a>
        <a href="#" onclick="filterTasks('pending')">Pending Tasks</a>
        <a href="#" onclick="filterTasks('in-progress')">In Progress</a>
        <a href="#" onclick="filterTasks('completed')">Completed</a>
        <br><br><br><br><br><br><br><br><br><br><br><br>
       
    </div>

    <div class="container">
        <div class="header">
            
        </div>
        <div class="task-summary">
            <div class="summary-card pending">Pending: <span id="pendingCount">0</span></div>
            <div class="summary-card in-progress">In Progress: <span id="inProgressCount">0</span></div>
            <div class="summary-card completed">Completed: <span id="completedCount">0</span></div>
        </div>
        <div class="chart-container">
            <canvas id="taskChart"></canvas>
        </div>
        <div class="task-list">
            <h2>Maintenance Tasks</h2>
            <div class="task-item pending">
                <div class="task-details">
                    <p><strong>Task Name:</strong> Fix Leaky Faucet</p>
                    <p><strong>Location:</strong> Kitchen</p>
                    <p><strong>Task ID:</strong> 12345</p>
                    <p><strong>Due Date:</strong> 2025-01-10</p>
                    <p><strong>Urgency:</strong> High</p>
                </div>
                <div class="task-actions">
                    <button>Start Task</button>
                </div>
            </div>
            <div class="task-item in-progress">
                <div class="task-details">
                    <p><strong>Task Name:</strong> Replace Air Filter</p>
                    <p><strong>Location:</strong> HVAC System</p>
                    <p><strong>Task ID:</strong> 12346</p>
                    <p><strong>Due Date:</strong> 2025-01-15</p>
                    <p><strong>Urgency:</strong> Medium</p>
                </div>
                <div class="task-actions">
                    <button>Mark as Completed</button>
                </div>
            </div>
            <div class="task-item completed">
                <div class="task-details">
                    <p><strong>Task Name:</strong> Check Fire Alarm</p>
                    <p><strong>Location:</strong> Office Floor</p>
                    <p><strong>Task ID:</strong> 12347</p>
                    <p><strong>Completed Date:</strong> 2025-01-19</p>
                </div>
                <div class="task-actions">
                    <button disabled>Completed</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterTasks(status) {
    const tasks = document.querySelectorAll('.task-item');
    const summaryCards = document.querySelector('.task-summary');
    const chartContainer = document.querySelector('.chart-container');

    // Filter tasks based on status
    tasks.forEach(task => {
        if (status === 'all' || task.classList.contains(status)) {
            task.style.display = 'flex';
        } else {
            task.style.display = 'none';
        }
    });

    // Toggle visibility of the summary cards and chart
    if (status === 'all') {
        summaryCards.style.display = 'flex';
        chartContainer.style.display = 'block';
    } else {
        summaryCards.style.display = 'none';
        chartContainer.style.display = 'none';
    }

    // Update active class on sidebar links
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.classList.remove('active');
    });
    event.target.classList.add('active');
}

        function updateCounts() {
            const pendingCount = document.querySelectorAll('.task-item.pending').length;
            const inProgressCount = document.querySelectorAll('.task-item.in-progress').length;
            const completedCount = document.querySelectorAll('.task-item.completed').length;

            document.getElementById('pendingCount').textContent = pendingCount;
            document.getElementById('inProgressCount').textContent = inProgressCount;
            document.getElementById('completedCount').textContent = completedCount;

            const ctx = document.getElementById('taskChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Pending', 'In Progress', 'Completed'],
                    datasets: [{
                        data: [pendingCount, inProgressCount, completedCount],
                        backgroundColor: ['#ff6b6b', '#feca57', '#1dd1a1'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCounts();
        });
    </script>
</body>
</html>
