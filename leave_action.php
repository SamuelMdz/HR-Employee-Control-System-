<?php
require_once "config.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Only admins and managers can approve or reject
if ($_SESSION["role"] != "admin" && $_SESSION["role"] != "manager") {
    header("Location: leave.php");
    exit;
}

$id     = $_GET["id"];
$action = $_GET["action"];

// Only allow valid actions
if ($action != "approved" && $action != "rejected") {
    header("Location: leave.php");
    exit;
}

$sql    = "UPDATE leave_requests SET status = '$action' WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Fetch the leave request and employee details for the email
    $sql     = "SELECT lr.*, e.name AS employee_name
                FROM leave_requests lr
                JOIN employees e ON lr.employee_id = e.id
                WHERE lr.id = '$id'";
    $result  = mysqli_query($conn, $sql);
    $request = mysqli_fetch_assoc($result);

    // Send email notification via Brevo
    sendLeaveEmail($request, $action);

    header("Location: leave.php");
    exit;
} else {
    die("Error updating leave request: " . mysqli_error($conn));
}

function sendLeaveEmail($request, $status) {
    $name      = $request["employee_name"];
    $type      = $request["type"];
    $start     = $request["start_date"];
    $end       = $request["end_date"];
    $statusCap = ucfirst($status);
    $color     = $status == "approved" ? "#3CB371" : "#E74C3C";

    $htmlContent = "
        <div style='font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto;'>
            <div style='background-color: #1A2E4A; padding: 20px; text-align: center;'>
                <h1 style='color: white; margin: 0;'>CoreAxisHR</h1>
            </div>
            <div style='padding: 24px; background-color: #f9f9f9;'>
                <h2 style='color: #1A2E4A;'>Leave Request $statusCap</h2>
                <p>Dear <strong>$name</strong>,</p>
                <p>Your leave request has been
                   <strong style='color: $color;'>$statusCap</strong>.</p>
                <table style='width: 100%; border-collapse: collapse; margin-top: 16px;'>
                    <tr style='background-color: #EAF1FE;'>
                        <td style='padding: 8px 12px; font-weight: bold;'>Leave Type</td>
                        <td style='padding: 8px 12px;'>$type</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px 12px; font-weight: bold;'>Start Date</td>
                        <td style='padding: 8px 12px;'>$start</td>
                    </tr>
                    <tr style='background-color: #EAF1FE;'>
                        <td style='padding: 8px 12px; font-weight: bold;'>End Date</td>
                        <td style='padding: 8px 12px;'>$end</td>
                    </tr>
                </table>
                <p style='margin-top: 24px; color: #5A6A7A; font-size: 13px;'>
                    If you have any questions please contact HR.
                </p>
            </div>
            <div style='background-color: #1A2E4A; padding: 12px; text-align: center;'>
                <p style='color: rgba(255,255,255,0.6); font-size: 12px; margin: 0;'>
                    CoreAxisHR — Automated Notification
                </p>
            </div>
        </div>
    ";

    $data = json_encode([
        "sender" => [
            "name"  => MAIL_NAME,
            "email" => MAIL_FROM
        ],
        "to" => [
            [
                "email" => MAIL_FROM,
                "name"  => $name
            ]
        ],
        "subject"     => "Your Leave Request Has Been $statusCap — CoreAxisHR",
        "htmlContent" => $htmlContent
    ]);

    $ch = curl_init("https://api.brevo.com/v3/smtp/email");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "api-key: " . BREVO_API_KEY
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
}
?>
