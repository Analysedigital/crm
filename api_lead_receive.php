<?php
require '../config/db.php';
require '../functions.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


$input = json_decode(file_get_contents('php://input'), true);

$api_key = $input['api_key'] ?? '';
if (!$api_key) {
    http_response_code(401);
    echo json_encode(['error' => 'API key required']);
    exit;
}

$db->where('api_key', $api_key);
$vendor = $db->getOne('vendors');
if (!$vendor) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid API key']);
    exit;
}

$name = trim($input['name'] ?? '');
$email = trim($input['email'] ?? '');
$phone = trim($input['phone'] ?? '');
$subject = trim($input['subject'] ?? '');

if (!$name || !$email || !$phone || !$subject) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$source_id = $input['source_id'] ?? null;
$sub_source = trim($input['sub_source'] ?? '');
$domain = $vendor['domain'] ?? '';
$vendor_id = $vendor['id'] ?? null;


$round_robin_enabled = $db->where('options_name', 'round_robin')->getValue('options', 'options_value');
if($round_robin_enabled==='on'){

//Fetch available agents (round robin)
$db->where('role', 'agent');
$agents = $db->get('users', null, 'id,name');
if (empty($agents)) {
    http_response_code(500);
    echo json_encode(['error' => 'No agents available for assignment']);
    exit;
}

$last_agent_id = $db->where('k', 'last_agent_id')->getValue('settings', 'v');

$agent_ids = array_column($agents, 'id');
$next_agent_id = $agent_ids[0]; // default first
if ($last_agent_id && in_array($last_agent_id, $agent_ids)) {
    $pos = array_search($last_agent_id, $agent_ids);
    $next_agent_id = $agent_ids[($pos + 1) % count($agent_ids)];
}

$lead_data = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'subject' => $subject,
    'source_id' => $source_id,
    'sub_source' => $sub_source,
    'domain' => $domain,
    'vendor_id' => $vendor_id,
    'assigned_agent' => $next_agent_id,
    'created_at' => date('Y-m-d H:i:s')
];

if (!$db->insert('leads', $lead_data)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to insert lead', 'db_error' => $db->getLastError()]);
    exit;
}

$lead_id = $db->getInsertId();

try {
    $db->insert('lead_assignments', [
        'lead_id' => $lead_id,
        'agent_id' => $next_agent_id,
        'assigned_by' => null, 
        'reason' => 'Round-Robin',
        'assigned_at' => date('Y-m-d H:i:s')
    ]);

    $agent = $db->where('id', $next_agent_id)->getOne('users', ['name', 'email']);

    if ($agent) {

       
        $subject = "New Lead Assigned to You";
        $body = "<h3>Hello {$agent['name']},</h3>
            <p>You have been assigned a new lead.</p>
            <h4>Lead Details:</h4>
            <ul>
                <li><strong>Name:</strong> {$lead_data['name']}</li>
                <li><strong>Email:</strong> {$lead_data['email']}</li>
                <li><strong>Phone:</strong> {$lead_data['phone']}</li>
                <li><strong>Subject:</strong> {$lead_data['subject']}</li>
            </ul>
            <p>Please log in to your CRM to follow up.</p>
            <p>— CRM Notification System</p>";
        sendMail($agent['email'], $agent['name'], $subject, $body);
    }

}  catch (Exception $e) {
    error_log("Mail error: " . $e->getMessage());
}

try {
    $exists = $db->where('k', 'last_agent_id')->getValue('settings', 'COUNT(*)');
    if ($exists) {
        $db->where('k', 'last_agent_id')->update('settings', ['v' => $next_agent_id]);
    } else {
        $db->insert('settings', ['k' => 'last_agent_id', 'v' => $next_agent_id]);
    }
} catch (Exception $e) {

}

echo json_encode([
    'success' => true,
    'lead_id' => $lead_id,
    'assigned_agent' => $next_agent_id,
    'vendor_id' => $vendor_id
]);
} 