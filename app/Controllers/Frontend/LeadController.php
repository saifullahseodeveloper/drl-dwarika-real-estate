<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Lead;

class LeadController extends Controller
{
    public function submit(): void
    {
        $this->validateCsrf();

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $propertyId = !empty($_POST['property_id']) ? (int)$_POST['property_id'] : null;
        $serviceId = !empty($_POST['service_id']) ? (int)$_POST['service_id'] : null;
        $subject = trim($_POST['subject'] ?? 'Website Inquiry');

        $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
               || (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));

        // Basic validation
        if (empty($name) || empty($phone) || (empty($email) && empty($phone))) {
            $errorMsg = 'Please provide your full name and a valid phone number.';
            if ($isAjax) {
                $this->jsonResponse(['success' => false, 'error' => $errorMsg], 422);
            }
            Session::flash('error', $errorMsg);
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/contact-us');
            return;
        }

        // Spam honeypot check
        if (!empty($_POST['website_hp'])) {
            // Silently discard bot submission
            if ($isAjax) {
                $this->jsonResponse(['success' => true, 'message' => 'Thank you for reaching out! Our property specialist will contact you shortly.']);
            }
            Session::flash('success', 'Thank you! We have received your inquiry.');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/contact-us');
            return;
        }

        $leadId = Lead::create([
            'property_id' => $propertyId,
            'service_id'  => $serviceId,
            'name'        => $name,
            'email'       => $email,
            'phone'       => $phone,
            'subject'     => $subject,
            'message'     => $message,
        ]);

        $successMsg = 'Thank you! Your inquiry has been sent. A Dwarika property advisor will contact you within 2 hours.';

        if ($isAjax) {
            $this->jsonResponse([
                'success' => true,
                'lead_id' => $leadId,
                'message' => $successMsg
            ]);
        }

        Session::flash('success', $successMsg);
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/contact-us');
    }
}
