<?php
require 'includes/auth_check.php';
require 'config/db.php';
require 'functions.php';


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

// Fetch agents for dropdown (admin only)
$agents = $db->get('users', null, 'id,name');

// Fetch active vendors for dropdown
$vendors = $db->where('status',1)->get('vendors', null, 'id,name,domain');
$sources = $db->get('lead_sources', null, 'id,name');

$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
     // Prepare lead data
    $lead_data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'phone' => trim($_POST['phone']),
        'alternate_phone' => $_POST['alternate_phone'] ?? null,
        'whatsapp_number' => $_POST['whatsapp_number'] ?? null,
        'address' => $_POST['address'] ?? null,
        'city' => $_POST['city'] ?? null,
        'state' => $_POST['state'] ?? null,
        'pincode' => $_POST['pincode'] ?? null,
        'subject' => $_POST['subject'] ?? null,
        'project_name' => $_POST['project_name'] ?? null,
        'property_type' => $_POST['property_type'] ?? null,
        'location_interested' => $_POST['location_interested'] ?? null,
        'budget_min' => $_POST['budget_min'] ?? null,
        'budget_max' => $_POST['budget_max'] ?? null,
        'source_id' => $_POST['source_id'] ?? null,
        'sub_source' => $_POST['sub_source'] ?? null,
        'vendor_id' => $_POST['vendor_id'] ?? null,
        'domain' => $_POST['domain'] ?? null,
        'assigned_agent' => $_POST['assigned_agent'] ?? null,
        'status' => $_POST['status'] ?? 'new',
        'priority' => $_POST['priority'] ?? 'medium',
        'lead_stage' => $_POST['lead_stage'] ?? 'new',
        'followup_date' => $_POST['followup_date'] ?? null,
        'notes' => $_POST['notes'] ?? null,
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Insert lead
    $id = $db->insert('leads', $lead_data);

    if ($id) {
        $db->insert('lead_assignments', [
        'lead_id' => $id,
        'agent_id' => $_POST['assigned_agent'] ?? null,
        'assigned_by' => $_SESSION['user_id'] ?? null,
        'reason' => 'Manual assignment from admin panel'
        ]);

        $agent = $db->where('id', $_POST['assigned_agent'] )->getOne('users', ['name', 'email']);

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
        header('Location: leads_list.php');
        exit;
     }
     else{
        header('Location: leads_list.php');
        exit;
     }
}
?>
<?php include 'includes/header.php'; ?>
<div class="page-wrapper">
  <?php include 'includes/top_nav.php'?>
<div class="content-wrapper">
          <div class="content">
            <div class="card card-default">
                <div class="px-6 py-4 ">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-4 mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Phone *</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Alternate Phone</label>
            <input type="text" name="alternate_phone" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">WhatsApp Number</label>
            <input type="text" name="whatsapp_number" class="form-control">
        </div>

        <div class="col-md-8 mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">City</label>
            <input type="text" name="city" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">State</label>
            <input type="text" name="state" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Pincode</label>
            <input type="text" name="pincode" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Subject *</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Project Name</label>
            <input type="text" name="project_name" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Property Type</label>
            <input type="text" name="property_type" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Location Interested</label>
            <input type="text" name="location_interested" class="form-control">
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Budget Min</label>
            <input type="number" name="budget_min" class="form-control">
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Budget Max</label>
            <input type="number" name="budget_max" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Source</label>
            <select name="source_id" class="form-control">
                <option value="">Select Source</option>
                <?php
                $sources = $db->get('lead_sources');
                foreach ($sources as $src) {
                    echo "<option value='{$src['id']}'>{$src['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Sub Source</label>
            <input type="text" name="sub_source" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Assigned Agent</label>
            <select name="assigned_agent" class="form-control">
                <option value="">Select Agent</option>
                <?php
                $db->where('role', 'agent');
                $agents = $db->get('users');
                foreach ($agents as $agent) {
                    echo "<option value='{$agent['id']}'>{$agent['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="new">New</option>
                <option value="contacted">Contacted</option>
                <option value="follow_up">Follow Up</option>
                <option value="converted">Converted</option>
                <option value="lost">Lost</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Priority</label>
            <select name="priority" class="form-control">
                <option value="high">High</option>
                <option value="medium" selected>Medium</option>
                <option value="low">Low</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Lead Stage</label>
            <select name="lead_stage" class="form-control">
                <option value="new">New</option>
                <option value="qualified">Qualified</option>
                <option value="proposal">Proposal</option>
                <option value="negotiation">Negotiation</option>
                <option value="won">Won</option>
                <option value="lost">Lost</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Follow-up Date</label>
            <input type="date" name="followup_date" class="form-control">
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <div class="col-12">
            <button type="submit" class="btn ad-brand">Add Lead</button>
            <a href="leads_list.php" class="btn btn-secondary">Cancel</a>
        </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
</div>


