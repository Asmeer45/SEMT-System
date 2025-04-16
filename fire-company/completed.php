<?php
include('include/session_check.php');
checkRole('fire_company');
?>

<?php
include('side-bar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Tasks</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-left: 270px;
            width: calc(100% - 270px);
            padding: 20px;
            margin-top: 80px;
            margin-bottom: 150px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .action-button {
            padding: 5px 10px;
            margin: 5px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .action-button:hover {
            background-color: #0056b3;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 15px;
            line-height: 2;
            border: 1px solid #888;
            width: 50%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        /* Responsive Design
        @media screen and (max-width: 1024px) {
            .container {
                margin-left: 0;
                width: 100%;
            }


            .modal-content {
                width: 80%;
            }
        } */

        @media screen and (max-width: 768px) {
            body {
        flex-direction: column;
        align-items: center;
        padding: 0px;
    }
    .container {
                width: 90%;
        max-width: 100%;
        margin-left: 0;
        padding: 0px;
        box-shadow: none;
            }


            table { 
                
                display: block;
                overflow-x: auto;
                white-space: nowrap;
                }
            th, td { font-size: 14px; padding: 8px; }

            .action-button {
                padding: 5px 8px;
                font-size: 14px;
            }

            .modal-content {
                width: 90%;
                padding: 10px;
            }

            .close {
                font-size: 24px;
            }
        }

        @media screen and (max-width: 480px) {
            .container {
                margin-left: 0;
                flex-direction: column;
                width: 100%;
            }
h1{
    font-size:18px;
}
            table { 
                
                display: block;
                overflow-x: auto;
                white-space: nowrap;
                padding:2px;
                }
            th, td { font-size: 14px; padding: 8px; }
            /* table {
                margin-left: 0;
                width: 100%;
            }

            th, td {
                font-size: 12px;
                padding: 6px;
            } */

            .action-button {
                padding: 4px 6px;
                font-size: 12px;
            }

            .modal-content {
                width: 100%;
                padding: 8px;
                margin-top:60px;
            }

            .close {
                font-size: 20px;
            }
        }

    </style
    </style>
</head>
<body>
    <?php 


include('include/header.php');

    include('../include/config.php');

    // Query to fetch pending tasks
    $sql = "SELECT f.id, f.serial_number, f.service_type, f.request_date, f.priority, f.type, f.description, f.status, f.station_name, 
    f.platform_number, f.scheduled_service_date, f.service_date, f.repair_details, f.cost_estimation, f.quotation_id, f.invoice_id, 
    o.invoice_attachment, w.quotation_attachment FROM fire_extinguishers_requests f 
    INNER JOIN fire_extinguishers_invoice o ON f.id = o.repair_request_id
        INNER JOIN fire_extinguishers_quotations w ON f.id= w.repair_request_id
    WHERE f.status = 'Completed'";
    $result = $conn->query($sql);
    ?>

    <div class="container">
        <div class="header">
            <h1>Completed Tasks</h1>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Serial Number</th>
                    <th>Service Type</th>
                    <th>Request Date</th>
                    <th>Priority</th>
                    <th>Quotation Attachment</th>      
                    <th>Invoice Attachment</th>                 
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '    <td>' . $row['id'] . '</td>';
                        echo '    <td>' . $row['serial_number'] . '</td>';
                        echo '    <td>' . $row['service_type'] . '</td>';
                        echo '    <td>' . $row['request_date'] . '</td>';
                        echo '    <td>' . $row['priority'] . '</td>';
                        echo '    <td><a href="' . $row['quotation_attachment'] . '" target="_self" class="">Open PDF</a></td>';
                        echo '    <td><a href="' . $row['invoice_attachment'] . '" target="_self" class="">Open PDF</a></td>';

                        echo '    <td style="display:none;">' . $row['type'] . '</td>';
                        echo '    <td style="display:none;">' . $row['description'] . '</td>';
                        echo '    <td style="display:none;">' . $row['status'] . '</td>';
                        echo '    <td style="display:none;">' . $row['station_name'] . '</td>';
                        echo '    <td style="display:none;">' . $row['platform_number'] . '</td>';
                        
                        echo '    <td style="display:none;">' . $row['scheduled_service_date'] . '</td>';
                        echo '    <td style="display:none;">' . $row['service_date'] . '</td>';
                        echo '    <td style="display:none;">' . $row['repair_details'] . '</td>';
                        echo '    <td style="display:none;">' . $row['cost_estimation'] . '</td>';
                        echo '    <td style="display:none;">' . $row['quotation_id'] . '</td>';
                        echo '    <td style="display:none;">' . $row['invoice_id'] . '</td>';
                        echo '    <td >
                                    <button class="action-button" onclick="openModal(' . $row['id'] . ', \'' . $row['serial_number'] . '\', \'' . $row['service_type'] . '\', 
                                    \'' . $row['request_date'] . '\', \'' . $row['scheduled_service_date'] . '\', \'' . $row['priority'] . '\',\'' 
                                    . $row['type'] . '\',\'' . $row['description'] . '\',\'' . $row['status'] . '\',\'' . $row['service_date'] . '\',\'' . $row['repair_details'] . '\',
                                    \'' . $row['cost_estimation'] . '\',\'' . $row['quotation_id'] . '\',\'' . $row['invoice_id'] . '\',\'' . $row['station_name'] . '\',\'' . $row['platform_number'] . '\')">View</button>

                                    
                                </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No pending tasks found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Structure -->
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Completed Task Details</h2>
            <p><strong>Request ID:</strong> <span id="modalRequestId"></span></p>
            <p><strong>Serial Number:</strong> <span id="modalSerialNumber"></span></p>
            <p><strong>Service Type:</strong> <span id="modalServiceType"></span></p>
            <p><strong>Request Date:</strong> <span id="modalRequestDate"></span></p>

            <p><strong>Scheduled Service Date:</strong> <span id="modalScheduledServiceDate"></span></p>

            <p><strong>Priority:</strong> <span id="modalPriority"></span></p>
            <p><strong>Type:</strong> <span id="modalType"></span></p>
            <p><strong>Description:</strong> <span id="modalDescription"></span></p>
            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            
            <p><strong>Service Date:</strong> <span id="modalServiceDate"></span></p>
            <p><strong>Repair Details:</strong> <span id="modalRepairDetails"></span></p>
            <p><strong>Cost Estimation:</strong> <span id="modalCostEstimation"></span></p>
            <p><strong>Quotation Id:</strong> <span id="modalQuotationId"></span></p>
            <p><strong>Invoice Id:</strong> <span id="modalInvoiceId"></span></p>

            <p><strong>Station Name:</strong> <span id="modalStationName"></span></p>
            <p><strong>Platform Number:</strong> <span id="modalPlatformNumber"></span></p>


            <button class="action-button" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        function openModal(id, serialNumber, serviceType, requestDate, scheduledServiceDate, priority, type, description, status, 
        serviceDate, repairDetails, costEstimation, quotationId, invoiceId,
        stationName, platformNumber) {
            document.getElementById('modalRequestId').innerText = id;
            document.getElementById('modalSerialNumber').innerText = serialNumber;
            document.getElementById('modalServiceType').innerText = serviceType;
            document.getElementById('modalRequestDate').innerText = requestDate;

            document.getElementById('modalScheduledServiceDate').innerText = scheduledServiceDate;

            document.getElementById('modalPriority').innerText = priority;
            document.getElementById('modalType').innerText = type;
            document.getElementById('modalDescription').innerText = description;
            document.getElementById('modalStatus').innerText = status;


            document.getElementById('modalServiceDate').innerText = serviceDate;
            document.getElementById('modalRepairDetails').innerText = repairDetails;
            document.getElementById('modalCostEstimation').innerText = costEstimation;
            document.getElementById('modalQuotationId').innerText = quotationId;
            document.getElementById('modalInvoiceId').innerText = invoiceId;;

            document.getElementById('modalStationName').innerText = stationName;
            document.getElementById('modalPlatformNumber').innerText = platformNumber;
            document.getElementById('taskModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('taskModal').style.display = 'none';
        }
    </script>
</body>
</html>
