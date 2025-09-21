<?php

namespace App\Services;

class EmailService
{
    /**
     * Generate the email content for a lead.
     * 
     * @param \App\Models\Lead $lead
     * @return array
     */
    public function generateEmailContent($lead)
    {
        // Split the full name into first and last names
        $nameParts = explode(' ', $lead->first_name);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        // Define the email subject and content
        $subject = "Hello, $firstName! Here's your message.";
        $content = "Dear $firstName $lastName, \n\nThis is a personalized message for you.";

        return [
            'subject' => $subject,
            'content' => $content
        ];
    }
}
